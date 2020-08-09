<?php

namespace App\Repositories;

use App\Models\Playlist;
use App\Models\Rss\Country;
use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use Cache;
use Illuminate\Support\Collection;

class PlaylistRepository implements PlaylistRepositoryInterface
{
    public function all(): Collection
    {
        return Playlist::ordered()->get(['id', 'title', 'videos']);
    }

    public function getHome(): Collection
    {
        return Cache::rememberForever(self::CACHE_HOME, function () {
            return Playlist::ordered()->whereIn('id', setting('playlists_home'))->get(['id', 'title', 'videos']);
        });
    }

    public function getByCountry(Country $country): Collection
    {
        return Playlist::ordered()->whereCountryId($country->id)->get(['id', 'title', 'videos']);
    }

}
