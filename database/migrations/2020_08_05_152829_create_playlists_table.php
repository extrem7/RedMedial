<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaylistsTable extends Migration
{
    public function up()
    {
        /* php artisan migrate:refresh --path=/database/migrations/2020_08_05_152829_create_playlists_table.php */
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('rss_countries');

            $table->string('title');
            $table->json('videos')->nullable();

            $table->unsignedBigInteger('order_column')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('playlists');
    }
}
