<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFavoriteChannelsTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_08_10_153222_create_user_favorite_channels_table.php */
    public function up()
    {
        Schema::create('user_favorite_channels', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('channel_id')->constrained('rss_channels')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_favorite_channels');
    }
}
