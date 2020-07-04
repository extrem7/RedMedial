<?php

use App\Models\Rss\Channel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssChannelsTable extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=/database/migrations/2020_07_01_102918_create_rss_channels_table.php
     * @return void
     */
    public function up()
    {
        $statuses = array_keys(Channel::$statuses);

        Schema::create('rss_channels', function (Blueprint $table) use ($statuses) {
            $table->id();

            $table->foreignId('country_id')->nullable()->constrained('rss_countries');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('feed');
            $table->string('link')->nullable();
            $table->string('description')->nullable();

            $table->boolean('is_active')->default(false);
            $table->enum('status', $statuses)->default(Channel::IDLE);
            $table->timestamp('last_run')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

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
        Schema::dropIfExists('rss_channels');
    }
}
