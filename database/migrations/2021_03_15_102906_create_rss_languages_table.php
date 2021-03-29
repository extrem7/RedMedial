<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssLanguagesTable extends Migration
{
    public function up(): void
    {
        Schema::create('rss_languages', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();
            $table->string('name');
            $table->string('code', 2)->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->unsignedBigInteger('order_column')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rss_languages');
    }
}
