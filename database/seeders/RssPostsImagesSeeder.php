<?php

namespace Database\Seeders;

use App\Models\Rss\Post;
use Illuminate\Database\Seeder;

class RssPostsImagesSeeder extends Seeder
{
    public function run()
    {
        /* @var $posts Post[] */
        Post::where('image', '!=', null)
            ->limit(100)
            ->orderByDesc('id')
            ->select(['id', 'image as image_link'])
            ->inRandomOrder()
            ->chunk(100, function ($posts) {
                $this->command->getOutput()->progressStart(count($posts));

                foreach ($posts as $post) {
                    $path = str_replace('https://redmedial.com/', '', $post->image_link);

                    if ($files = glob(base_path('../old.redmedial.com/' . $path))) {
                        //dump($files);
                        $post->addMedia($files[0])->preservingOriginal()->toMediaCollection('image');
                        DB::table('rss_posts')->where('id', $post->id)->update(['image' => null]);
                    }
                    $this->command->getOutput()->progressAdvance();
                }

                $this->command->getOutput()->progressFinish();
            });
    }
}
