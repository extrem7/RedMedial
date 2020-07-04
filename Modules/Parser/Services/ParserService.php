<?php


namespace Modules\Parser\Services;

use App\Models\Rss\Channel;
use App\Models\Rss\Post;
use Carbon\Carbon;
use DB;
use Exception;
use Feeds;
use Http;
use Illuminate\Console\Command;
use Log;
use Modules\Parser\Services\FullText\ContentExtractor\ContentExtractor;
use SimplePie;
use SimplePie_Item;
use Str;

class ParserService
{
    protected Command $command;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    public function start(): void
    {
        while (true) {
            $channels = $this->getChannels();
            if (empty($channels)) {
                $this->error('No active channels');
                return;
            }

            foreach ($channels as $channel) {
                $timeStart = microtime(true);

                $this->info("Start working on channel #$channel->id $channel->name");
                /* @var $feed SimplePie */
                $feed = Feeds::make($channel->feed);
                if ($feed->error() === null) {
                    $this->info('Feed has been fetched');

                    $this->updateLastRun($channel);

                    $items = $this->filterNewItems($feed, $channel);

                    $count = 0;

                    DB::transaction(function () use ($items, $channel, $count) {
                        foreach ($items as $item)
                            if ($itemRss = $this->createItem($item, $channel)) {
                                $count++;
                                $this->attachImage($item, $itemRss);
                            }
                    });

                    $this->info("Created $count items");
                } else {
                    $this->error('SimplePie returned error: ' . $feed->error());
                }

                $timeEnd = microtime(true);
                $executionTime = round($timeEnd - $timeStart, 1);
                $this->info("End working on channel #$channel->id $channel->name. Total Execution Time: {$executionTime}s");
            }
        }
    }

    /* @return Channel[] */
    protected function getChannels(): iterable
    {
        return Channel::active()->get(['id', 'name', 'feed'])->all();
    }

    protected function createItem(SimplePie_Item $item, Channel $channel): ?Post
    {
        $date = Carbon::create($item->get_date());
        try {
            $content = $this->parseFullContent($item);
        } catch (Exception $e) {
            $this->error("Error while parsing full content in file :\n"
                . $e->getFile() . ' line: ' . $e->getLine() . "\n"
                . $e->getMessage());
        }


        $post = new Post([
            'channel_id' => $channel->id,
            'title' => $item->get_title(),
            'excerpt' => $item->get_description(),
            'body' => $content ?? $item->get_content(),
            'link' => $item->get_link(),
            'created_at' => $date
        ]);

        try {
            if ($post->save()) return $post;
        } catch (Exception $e) {
            $this->error(
                "Error while saving item to DB in file :\n"
                . $e->getFile() . ' line: ' . $e->getLine() . "\n"
                . $e->getMessage()
            );
        }
        return null;
    }

    protected function attachImage(SimplePie_Item $item, Post $itemRss): void
    {
        $enclosure = $item->get_enclosure();
        if (Str::contains($enclosure->get_type(), 'image')) {
            $url = $enclosure->get_link();
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

        $items = array_reverse($feed->get_items(0, 10));

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

    protected function parseFullContent(SimplePie_Item $item)
    {
        $extractor = new ContentExtractor(
            module_path('parser', '/Services/FullText/ContentExtractor/config/standart')
        );

        $html = Http::get($item->get_link());

        $extract_result = $extractor->process($html, $item->get_link());
        $readability = $extractor->readability;
        $content_block = ($extract_result) ? $extractor->getContent() : null;

        $readability->clean($content_block, 'select');
        // remove empty text nodes
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

        //unset($content_block);
        // post-processing cleanup
        $html = preg_replace('!<p>[\s\h\v]*</p>!u', '', $html);

        return $html;
    }

    protected function info(string $message): void
    {
        $this->command->info($message);
        Log::channel('rss')->info($message);
    }

    protected function error(string $message): void
    {
        $this->command->error($message);
        Log::channel('rss')->error($message);
    }
}
