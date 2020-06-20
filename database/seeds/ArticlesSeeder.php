<?php

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=PostsTableSeeder
     *
     * @return void
     */
    public function run()
    {
        factory(Article::class, (int)env('ARTICLES_SEEDER_COUNT', 100))->create()->each(function (Article $article) {
            $article->addMediaFromUrl('https://picsum.photos/750/370')->toMediaCollection('image');
        });
    }
}
