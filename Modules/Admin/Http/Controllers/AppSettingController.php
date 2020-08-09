<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Playlist;
use App\Models\Rss\Channel;
use Illuminate\Http\Request;
use QCod\AppSettings\SavesSettings;
use QCod\AppSettings\Setting\AppSettings;

class AppSettingController extends Controller
{
    use SavesSettings {
        index as parentIndex;
        store as parentStore;
    }

    public function index(AppSettings $appSettings)
    {
        $this->seo()->setTitle('Settings');

        $selectedChannels = setting('international_medias');
        $channels = Channel::get(['id', 'name'])->map(function (Channel $channel) use ($selectedChannels) {
            return [
                'id' => $channel->id,
                'text' => $channel->name,
                'selected' => in_array($channel->id, $selectedChannels)
            ];
        });

        $selectedPlayers = setting('playlists_home');
        $playlists = Playlist::ordered()->get(['id', 'title'])->map(function (Playlist $playlist) use ($selectedPlayers) {
            return [
                'id' => $playlist->id,
                'text' => $playlist->title,
                'selected' => in_array($playlist->id, $selectedPlayers)
            ];
        });

        share([
            'international_medias' => $channels,
            'playlists_home' => $playlists
        ]);

        return $this->parentIndex($appSettings);
    }

    public function store(Request $request, AppSettings $appSettings)
    {
        $international_medias = setting('international_medias');
        $playlists_home = setting('playlists_home');
        $response = $this->parentStore($request, $appSettings);

        if ($request->input('international_medias') !== implode(',', $international_medias)) {
            \Cacher::channelsInternational();
        }
        if ($request->input('playlists_home') !== implode(',', $playlists_home)) {
            \Cacher::playlistsHome();
        }
        return $response;
    }
}
