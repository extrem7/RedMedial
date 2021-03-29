<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageIdToRssChannels extends Migration
{
    public function up(): void
    {
        Schema::table('rss_channels', function (Blueprint $table) {
            $table->foreignId('language_id')
                ->nullable()
                ->after('country_id')
                ->constrained('rss_languages');
        });
    }

    public function down(): void
    {
        Schema::table('rss_channels', function (Blueprint $table) {
            $table->dropForeign('rss_channels_language_id_foreign');
            $table->dropColumn('language_id');
        });
    }
}
