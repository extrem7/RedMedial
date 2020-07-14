<?php

namespace Modules\Parser\Services;

use App\Models\Rss\Category;
use App\Models\Rss\Channel;
use App\Models\Rss\Post;

use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Parser\Services\FullText\ContentExtractor\ContentExtractor;

use SimplePie;
use SimplePie_Item;

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
        $this->categories = Category::all('id', 'keywords');
    }

    public function start(): void
    {
        while ($this->run) {
            $channels = $this->getChannels();
            if (empty($channels)) {
                $this->error('No active channels');
                return;
            }

            foreach ($channels as $channel) {
                $timeStart = microtime(true);

                $channel->refresh();
                if ($channel->status === Channel::WORKING) {
                    if ($channel->last_run === null || $channel->last_run->diffInMinutes() < 2) continue;
                }

                $this->info("Start working on channel #$channel->id $channel->slug");
                $this->updateLastRun($channel);
                $channel->update(['status' => Channel::WORKING]);
                /* @var $feed SimplePie */
                $feed = \Feeds::make($channel->feed, null, true);
                if ($feed->error() === null) {
                    $this->info('Feed has been fetched');

                    $items = $this->filterNewItems($feed, $channel);

                    $count = 0;

                    \DB::transaction(function () use ($items, $channel, &$count) {
                        foreach ($items as $item) {
                            $this->html = null;

                            if ($post = $this->createItem($item, $channel)) {
                                $count++;
                                $this->attachImage($item, $post, $channel->use_og);
                                $this->attachToCategories($item, $post);
                            }
                        }
                    });

                    $this->info("Created $count items");

                    if (in_array($channel->id, setting('international_medias'))) {
                        $this->channelRepository->cacheInternational();
                    }
                    if ($country = $channel->country) {
                        if ($count > 0) $this->countryRepository->cacheByCode($country->code);
                    }
                } else {
                    $this->error('SimplePie returned error: ' . $feed->error());
                }

                $timeEnd = microtime(true);
                $executionTime = round($timeEnd - $timeStart, 1);
                $this->info("End working on channel #$channel->id $channel->slug. Total Execution Time: {$executionTime}s");
                $channel->update(['status' => Channel::IDLE]);
            }
        }
    }

    public function stop()
    {
        $this->run = false;
    }

    /* @return Channel[] */
    protected function getChannels(): iterable
    {
        return Channel::active()
            ->when($this->command->option('international'), function ($query) {
                $query->whereIn('id', setting('international_medias'));
            })
            ->when($this->command->option('country'), function ($query) {
                $query->where('country_id', (int)$this->command->option('country'));
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

        if ($channel->use_og | $channel->use_fulltext) {
            $this->html = \Http::get($item->get_link());
            if ($channel->use_fulltext) {
                try {
                    $content = $this->parseFullContent($item) ?? $content;
                } catch (\Exception $e) {
                    $this->error("Error while parsing full content in file :\n"
                        . $e->getFile() . ' line: ' . $e->getLine() . "\n"
                        . $e->getMessage());
                }
            }
        }

        $post = new Post([
            'channel_id' => $channel->id,
            'title' => strip_tags(htmlspecialchars_decode($item->get_title())),
            'excerpt' => strip_tags(mb_substr($item->get_description(), 0, 510)),
            'body' => $content,
            'link' => $item->get_link(),
            'created_at' => $date
        ]);

        try {
            if ($post->save()) return $post;
        } catch (\Exception $e) {
            $this->error(
                "Error while saving item to DB in file :\n"
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

        if (\Str::contains($enclosure->get_type(), 'image')) {
            $url = $enclosure->get_link();
        } else if ($useOG) {
            $url = $this->parseOGTagsForImage();
        }
        if ($url !== null) {
            try {
                $itemRss->uploadImage($url);
            } catch (\Exception $e) {
                $this->error("Error while attaching image to post $itemRss->id :\n {$e->getMessage()}");
            }
        }
    }

    /* @return SimplePie_Item[] */
    protected function filterNewItems(SimplePie $feed, Channel $channel): array
    {
        $startTime = $channel->posts()->latest()->first()->created_at ?? null;

        $items = array_reverse($feed->get_items(0, config('parser.posts_limit')));

        return array_filter($items, function ($item) use ($startTime) {
            $date = Carbon::create($item->get_date());
            return $date->greaterThan($startTime);
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
    \b(?:name|property|http-equiv)\s*=\s*
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

    protected function attachToCategories(SimplePie_Item $item, Post $post)
    {
        $fields = [$post->title, $post->excerpt, $post->body];

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
                        $category->posts()->attach($post->id);
                        if ($category->id == config('redmedial.covid_category')) {
                            $this->postRepository->cacheCovid();
                        }
                        $categoryBreak = true;
                        break;
                    }
                }
            }
        }
    }

    protected function info($message): void
    {
        if (is_array($message)) $message = print_r($message, true);
        $this->command->info($message);
        \Log::channel('rss')->info($message);
    }

    protected function error(string $message): void
    {
        if (is_array($message)) $message = print_r($message, true);
        $this->command->error($message);
        \Log::channel('rss')->error($message);
    }
}
