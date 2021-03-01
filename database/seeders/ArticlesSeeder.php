<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    public function run(): void
    {
        \DB::transaction(function () {
            $articles = collect(json_decode(file_get_contents(database_path('old/articles.json'))));

            $this->command->getOutput()->progressStart(count($articles));

            $articles->each(function ($data, $i) {
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
                    $article->addMedia($files[0])->preservingOriginal()->toMediaCollection('image');
                }

                $this->command->getOutput()->progressAdvance();
            });

            $this->command->getOutput()->progressFinish();
        });
    }
}
