<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssCountriesTable extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=/database/migrations/2020_06_25_151002_create_rss_countries_table.php
     * @return void
     */
    public function up()
    {
        Schema::create('rss_countries', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();
            $table->string('name');
            $table->string('code', 2)->nullable();

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
        Schema::dropIfExists('rss_countries');
    }
}
