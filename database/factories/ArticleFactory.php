<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(12),
            'excerpt' => $this->faker->text(140),
            'body' => $this->faker->realText(1000),
            'authors' => $this->faker->word,
            'original' => $this->faker->url,
            'status' => Article::PUBLISHED
        ];
    }
}
