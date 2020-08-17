<?php

use App\Models\Rss\Post;
use Illuminate\Database\Seeder;

class RssPostsSeeder extends Seeder
{
    public function run()
    {
        $channels = require(database_path('old/channelsMapping.php'));
        $posts = Http::get('https://redmedial.com/wp-json/app/v1/migration?limit=20&offset=600000')->json()['data']['posts'];

        $this->command->getOutput()->progressStart(count($posts));

        DB::transaction(function () use ($posts, $channels) {
            foreach ($posts as $data) {
                $post = Post::create([
                    'channel_id' => $channels[$data['channel_id']],
                    'title' => strip_tags($data['title']),
                    'created_at' => $data['date'],
                    'excerpt' => strip_tags(html_entity_decode($data['excerpt'])),
                    'body' => $data['body'],
                    'source' => $data['link'],
                    'image' => $data['image']
                ]);

                //  $post->addMediaFromUrl($data['image'])->toMediaCollection('image', 's3');

                $this->command->getOutput()->progressAdvance();
            }
        });

        $this->command->getOutput()->progressFinish();
    }
}
