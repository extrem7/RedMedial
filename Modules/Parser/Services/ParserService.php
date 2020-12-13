<?php

namespace Modules\Parser\Services;

use App\Models\Rss\Category;
use App\Models\Rss\Channel;
use App\Models\Rss\Post;

use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;

use Cacher;
use Carbon\Carbon;
use DB;
use Exception;
use Feeds;
use Http;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Log;
use Modules\Parser\Services\FullText\ContentExtractor\ContentExtractor;

use SimplePie;
use SimplePie_Item;
use Str;

class ParserService
{
    protected Command $command;

    protected CountryRepositoryInterface $countryRepository;
    protected ChannelRepositoryInterface $channelRepository;
    protected PostRepositoryInterface $postRepository;

    protected Collection $categories;

    protected ?string $html;

    private bool $run = true;

    public function __construct(Command $command)
    {
        $this->command = $command;
        $this->countryRepository = app(CountryRepositoryInterface::class);
        $this->channelRepository = app(ChannelRepositoryInterface::class);
        $this->postRepository = app(PostRepositoryInterface::class);
    }

    public function start(): void
    {
        $this->categories = Category::all('id', 'keywords');
        $channels = $this->getChannels();
        if (empty($channels)) {
            $this->error('No active channels');
            return;
        }

        foreach ($channels as $channel) {
            $timeStart = microtime(true);

            //$channel->refresh();
            if ($channel->status === Channel::WORKING) {
                if ($channel->last_run === null || $channel->last_run->diffInMinutes() < 2) continue;
            }

            $this->info(now()->format('Y-m-d H:i:s') . " Start working on channel #$channel->id $channel->slug");
            $this->updateLastRun($channel);
            $channel->update(['status' => Channel::WORKING]);
            /* @var $feed SimplePie */
            $feed = Feeds::make($channel->feed, null, true);
            if ($feed->error() === null) {
                $this->info('Feed has been fetched');

                $items = $this->filterNewItems($feed, $channel);

                $count = 0;
                $isNeedCacheRefresh = false;

                DB::transaction(function () use ($items, $channel, &$count, &$isNeedCacheRefresh) {
                    foreach ($items as $item) {
                        $this->html = null;

                        if ($post = $this->createItem($item, $channel)) {
                            $count++;
                            if (!config('parser.disable_image')) $this->attachImage($item, $post, $channel->use_og);
                            $isNeedCacheRefresh = $this->attachToCategories($item, $post);
                        }
                    }
                });

                if ($isNeedCacheRefresh) Cacher::postsHot();

                $this->info("Created $count items");

                if ($count > 0) {
                    if (in_array($channel->id, setting('international_medias'))) {
                        Cacher::channelsInternational();
                    }
                    if ($country = $channel->country) {
                        if ($count > 0) Cacher::countyByCode($country->code);
                    }
                }
            } else {
                $this->error('SimplePie returned error: ' . $feed->error());
            }

            $timeEnd = microtime(true);
            $executionTime = round($timeEnd - $timeStart, 1);
            $this->info("End working on channel #$channel->id $channel->slug. Total Execution Time: {$executionTime}s");
            $this->info('');
            $channel->update(['status' => Channel::IDLE]);
        }
    }

    public function stop(): void
    {
        $this->run = false;
    }

    /* @return Channel[] */
    protected function getChannels(): iterable
    {
        return Channel::active()
            ->when($this->command->option('international'), function (Builder $query) {
                $query->whereIn('id', setting('international_medias'));
            })
            ->when($this->command->option('international') === false, function (Builder $query) {
                $query->whereNotIn('id', setting('international_medias'));
            })
            ->when($this->command->option('country'), function (Builder $query) {
                $query->where('country_id', (int)$this->command->option('country'));
            })
            ->when($this->command->option('channel'), function (Builder $query) {
                $query->where('id', (int)$this->command->option('channel'));
            })
            ->with(['country'])
            ->orderBy('last_run')
            ->get(['id', 'country_id', 'slug', 'name', 'feed', 'use_fulltext', 'use_og', 'last_run', 'status'])
            ->all();
    }

    protected function createItem(SimplePie_Item $item, Channel $channel): ?Post
    {
        $content = $item->get_content();
        $date = Carbon::create($item->get_date());

        if (!config('parser.disable_full') && ($channel->use_og | $channel->use_fulltext)) {
            try {
                $this->html = Http::get($item->get_link());
            } catch (Exception $e) {
                $this->error("Error while trying to get post origin:\n"
                    . $e->getFile() . ' line: ' . $e->getLine() . "\n"
                    . $e->getMessage());
            }
            if ($channel->use_fulltext) {
                try {
                    $content = $this->parseFullContent($item) ?? $content;
                } catch (Exception $e) {
                    $this->error("Error while parsing full content in file :\n"
                        . $e->getFile() . ' line: ' . $e->getLine() . "\n"
                        . $e->getMessage());
                }
            }
        }

        $post = new Post([
            'channel_id' => $channel->id,
            'title' => strip_tags(htmlspecialchars_decode(htmlspecialchars_decode($item->get_title(), ENT_QUOTES))),
            'excerpt' => strip_tags(mb_substr($item->get_description(), 0, 510)),
            'body' => $content,
            'source' => $item->get_link(),
            'created_at' => $date
        ]);

        try {
            if ($post->save()) return $post;
        } catch (Exception $e) {
            $this->error(
                "Error while saving item to \DB in file :\n"
                . $e->getFile() . ' line: ' . $e->getLine() . "\n"
                . $e->getMessage()
            );
        }
        return null;
    }

    protected function attachImage(SimplePie_Item $item, Post $itemRss, bool $useOG = false): void
    {
        $enclosure = $item->get_enclosure();
        $url = null;

        if (Str::contains($enclosure->get_type(), 'image')) {
            $url = $enclosure->get_link();
        } else if ($useOG) {
            $url = $this->parseOGTagsForImage();
        }
        if ($url) {
            try {
                $itemRss->uploadImage($url);
            } catch (Exception $e) {
                $this->error("Error while attaching image to post $itemRss->id :\n {$e->getMessage()}");
            }
        }
    }

    /* @return SimplePie_Item[] */
    protected function filterNewItems(SimplePie $feed, Channel $channel): array
    {
        $startTime = $channel->posts()->latest()->first()->created_at ?? null;

        $items = array_reverse($feed->get_items(0, config('parser.posts_limit')));
        $titles = [];

        return array_filter($items, function ($item) use (&$titles, $startTime, $channel) {
            $date = Carbon::create($item->get_date());

            $title = $item->get_title();

            if ($date->lessThan($startTime) || $date->equalTo($startTime)) return false;

            if (array_search($title, $titles) === false) {
                $titles[] = $title;
            } else {
                return false;
            }

            return true;
        });
    }

    protected function updateLastRun(Channel $channel): void
    {
        $channel->last_run = Carbon::now();
        $channel->save();
    }

    protected function parseOGTagsForImage(): ?string
    {
        $pattern = '
  ~<\s*meta\s

  # using lookahead to capture type to $1
    (?=[^>]*?
    \b(?:name|property|\Http-equiv)\s*=\s*
    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
  )

  # capture content to $2
  [^>]*?\bcontent\s*=\s*
    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
  [^>]*>

  ~ix';

        if (preg_match_all($pattern, $this->html, $out)) {
            $tags = array_combine($out[1], $out[2]);
            return $tags['og:image'] ?? null;
        }
        return null;
    }

    protected function parseFullContent(SimplePie_Item $item)
    {
        $extractor = new ContentExtractor(
            module_path('parser', '/Services/FullText/ContentExtractor/config/standart')
        );
        $html = $this->html;
        $extract_result = $extractor->process($html, $item->get_link());
        $readability = $extractor->readability;
        $content_block = ($extract_result) ? $extractor->getContent() : null;

        $readability->clean($content_block, 'select');
        // remove empty text nodes
        if (is_object($content_block)) {
            foreach ($content_block->childNodes as $_n) {
                if ($_n->nodeType === XML_TEXT_NODE && trim($_n->textContent) == '') {
                    $content_block->removeChild($_n);
                }
            }
            // remove nesting: <div><div><div><p>test</p></div></div></div> = <p>test</p>
            while ($content_block->childNodes->length == 1 && $content_block->firstChild->nodeType === XML_ELEMENT_NODE) {
                // only follow these tag names
                if (!in_array(strtolower($content_block->tagName), array('div', 'article', 'section', 'header', 'footer'))) break;
                //$html = $content_block->firstChild->innerHTML; // FTR 2.9.5
                $content_block = $content_block->firstChild;
            }

            // convert content block to HTML string
            // Need to preserve things like body: //img[@id='feature']
            if (in_array(strtolower($content_block->tagName), array('div', 'article', 'section', 'header', 'footer', 'li', 'td'))) {
                $html = $content_block->innerHTML;
                //} elseif (in_array(strtolower($content_block->tagName), array('td', 'li'))) {
                //	$html = '<div>'.$content_block->innerHTML.'</div>';
            } else {
                $html = $content_block->ownerDocument->saveXML($content_block); // essentially outerHTML
            }
        }
        //unset($content_block);
        // post-processing cleanup
        $html = preg_replace('!<p>[\s\h\v]*</p>!u', '', $html);

        return $html;
    }

    protected function attachToCategories(SimplePie_Item $item, Post $post): bool
    {
        $isNeedCacheRefresh = false;
        $fields = [$post->title, $post->excerpt];

        $itemCategories = $item->get_categories();
        if (!empty($itemCategories)) {
            foreach ($itemCategories as $itemCategory) $fields[] = $itemCategory->get_label();
        }

        $categoryBreak = false;
        foreach ($this->categories as $category) {
            foreach ($category->keywords as $keyword) {
                if ($categoryBreak) {
                    $categoryBreak = false;
                    break;
                }
                foreach ($fields as $field) {
                    if (mb_stripos($field, $keyword) !== false) {
                        // dump($post->title, $field, $keyword);
                        $category->posts()->attach($post->id);
                        if ($category->id === config('frontend.hot_category')) {
                            $isNeedCacheRefresh = true;
                        }
                        $categoryBreak = true;
                        break;
                    }
                }
            }
        }

        return $isNeedCacheRefresh;
    }

    protected function info($message): void
    {
        if (config('app.debug')) {
            if (is_array($message)) {
                $message = print_r($message, true);
            }
            $this->command->info($message);
            Log::/*channel('rss')->*/ debug($message);
        }
    }

    protected function error(string $message): void
    {
        $message = print_r($message, true);
        $this->command->error($message);
        Log::/*channel('rss')->*/ warning($message);
    }
}
