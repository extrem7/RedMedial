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
        DB::transaction(function () {
            $articles = collect(json_decode(file_get_contents(database_path('old/articles.json'))));
            $articles->each(function ($data, $i) {
                dump($i);
                $data = [
                    'title' => htmlspecialchars_decode($data->title, ENT_QUOTES),
                    'slug' => $data->slug,
                    'excerpt' => htmlspecialchars_decode($data->excerpt),
                    'body' => htmlspecialchars_decode($data->body),
                    'created_at' => $data->created_at,
                    'status' => Article::PUBLISHED
                ];
                $article = Article::create((array)$data);
                if ($files = glob(resource_path('old/articles/' . ($i + 1) . '.*'))) {
                    dump($files[0]);
                    $article->addMedia($files[0])->preservingOriginal()->toMediaCollection('image');
                }
            });
        });
    }
}
