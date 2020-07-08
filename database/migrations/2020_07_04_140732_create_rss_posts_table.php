<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssPostsTable extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=/database/migrations/2020_07_04_140732_create_rss_posts_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('rss_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('channel_id')->constrained('rss_channels')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('excerpt', 510);
            $table->text('body');
            $table->string('link');

            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rss_posts');
    }
}
