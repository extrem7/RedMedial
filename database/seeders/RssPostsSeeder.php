<?php

namespace Database\Seeders;

use App\Models\Rss\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RssPostsSeeder extends Seeder
{
    public function run()
    {
        $channels = require(database_path('old/channelsMapping.php'));

        $total = env('MIGRATE_TOTAL', 670) * 1000;
        $limit = env('MIGRATE_LIMIT', 5000);
        $i = env('MIGRATE_OFFSET', 0);
        while (($limit * $i) < $total) {
            $offset = $limit * $i;
            $percent = intval(($offset / $total) * 100);
            dump("$percent%/100 Offset:$offset\n");
            $posts = Http::get("https://redmedial.com/wp-json/app/v1/migration?limit=$limit&offset=$offset")->json()['data']['posts'];
            $this->command->getOutput()->progressStart(count($posts));

            DB::transaction(function () use ($posts, $channels) {
                foreach ($posts as $data) {
                    $date = Carbon::create($data['date']);
                    if (!isset($channels[$data['channel_id']])) {
                        continue;
                    }
                    try {
                        $title = strip_tags($data['title']);
                        $channel_id = $channels[$data['channel_id']] + 1;
                        DB::table('rss_posts')->insert([
                            'channel_id' => $channel_id,
                            'title' => $title,
                            //'slug' => Str::slug($title),
                            'created_at' => $data['date'],
                            'excerpt' => strip_tags(html_entity_decode($data['excerpt'])),
                            'body' => $data['body'],
                            'source' => $data['link'],
                            'image' => ($date->diffInMonths() <= 2) && $data['image'] ? $data['image'] : DB::raw('NULL')
                        ]);
                    } catch (Exception $exception) {
                        dump($exception->getMessage());
                    }

                    //  $post->addMediaFromUrl($data['image'])->toMediaCollection('image', 's3');

                    $this->command->getOutput()->progressAdvance();
                }
            });

            $this->command->getOutput()->progressFinish();
            $i++;
        }
    }
}
