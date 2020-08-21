<?php

use App\Models\Rss\Post;
use Illuminate\Database\Seeder;

class RssPostsImagesSeeder extends Seeder
{
    public function run()
    {
        /* @var $posts Post[] */
        $posts = Post::where('image', '!=', null)
            ->limit(100)
            ->orderByDesc('id')
            ->get(['id', 'image as image_link']);

        $this->command->getOutput()->progressStart(count($posts));

        foreach ($posts as $post) {
            $path = str_replace('https://redmedial.com/', '', $post->image_link);
            //$post->addMediaFromUrl($post->image_link)->toMediaCollection('image', 's3');
            //$post->update(['image' => null]);

            $this->command->getOutput()->progressAdvance();
            /*if ($files = glob(base_path('../redmedial.com/' . $path))) {
                $post->addMedia($files[0])->preservingOriginal()->toMediaCollection('image', 's3');
            }*/
        }

        $this->command->getOutput()->progressFinish();
    }
}
