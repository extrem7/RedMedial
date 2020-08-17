<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersInformationTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_08_10_100655_create_users_information_table.php */
    public function up()
    {
        Schema::create('users_information', function (Blueprint $table) {
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('country_id')->nullable()->constrained('rss_countries')->onDelete('SET NULL');

            $table->string('bio')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_information');
    }
}
