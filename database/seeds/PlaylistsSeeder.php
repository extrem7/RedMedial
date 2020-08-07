<?php

use App\Models\Playlist;
use Illuminate\Database\Seeder;

class PlaylistsSeeder extends Seeder
{
    public function run()
    {
        $playlists = Http::get('https://redmedial.com/wp-json/app/v1/youtube')->json()['data'];

        foreach ($playlists as $playlist) {
            Playlist::create([
                'title' => $playlist['title'],
                'videos' => $playlist['videos']
            ]);
        }
    }
}
