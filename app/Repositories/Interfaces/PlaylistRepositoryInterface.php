<?php

namespace App\Repositories\Interfaces;

use App\Models\Playlist;
use App\Models\Rss\Country;
use Illuminate\Support\Collection;

interface PlaylistRepositoryInterface
{
    public const CACHE_HOME = 'playlists.home';

    /* @return Playlist[]|Collection */
    public function all(): Collection;

    /* @return Playlist[]|Collection */
    public function getHome(): Collection;

    /* @return Playlist[]|Collection */
    public function getByCountry(Country $country): Collection;
}
