<?php

use App\Models\Article;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=/database/migrations/2020_06_19_124820_create_articles_table.php
     * @return void
     */
    public function up()
    {
        $statuses = array_keys(Article::$statuses);

        Schema::create('articles', function (Blueprint $table) use ($statuses) {
            $table->id();

            $table->string('slug')->unique();
            $table->string('title');
            $table->string('excerpt', 510)->nullable();
            $table->text('body');

            $table->string('authors')->nullable();
            $table->string('original')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->enum('status', $statuses)->default(Article::DRAFT);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
