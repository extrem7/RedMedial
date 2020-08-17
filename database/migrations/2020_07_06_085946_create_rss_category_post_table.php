<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssCategoryPostTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_07_06_085946_create_rss_category_post_table.php */
    public function up()
    {
        Schema::create('rss_category_post', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained('rss_posts')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('rss_categories')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rss_category_post');
    }
}
