<?php

/** @var Factory $factory */

use App\Models\Article;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->sentence,
        'excerpt' => $faker->text(140),
        'body' => $faker->realText(1000),
        'status' => collect(Article::$statuses)->values()->random()
    ];
});
