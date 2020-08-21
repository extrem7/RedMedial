<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssPostsTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_07_04_140732_create_rss_posts_table.php */
    public function up()
    {
        Schema::create('rss_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('channel_id')->constrained('rss_channels')->cascadeOnDelete();
            $table->string('slug')->unique()->nullable();
            $table->string('title');
            $table->string('excerpt', 510);
            $table->text('body');
            $table->string('source');

            // temporary column
            $table->string('image')->nullable();

            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rss_posts');
    }
}
