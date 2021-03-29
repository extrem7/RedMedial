<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersMediaInformationTable extends Migration
{
    public function up(): void
    {
        Schema::create('users_media_information', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->unique()->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('url');
            $table->string('facebook')->nullable();
            $table->string('phone')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('rss')->nullable();
            $table->string('comment')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_media_information');
    }
}
