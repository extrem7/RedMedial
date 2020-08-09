<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Playlist;

/**
 * @group  Playlists
 */
class PlaylistController extends Controller
{
    /**
     * @api {get} /playlists List of playlists with videos
     * @apiName GetPlaylists
     * @apiGroup Playlists
     *
     * @apiSuccess {String} title Playlist title.
     * @apiSuccess {Object[]} videos Playlist videos.
     * @apiSuccess {String} videos.title Video title.
     * @apiSuccess {Number} videos.id Video id.
     * @apiSuccess {String} videos.duration Video duration.
     *
     */
    public function __invoke()
    {
        $playlists = Playlist::ordered()->get(['title', 'videos']);
        return $this->response->array($playlists->toArray());
    }
}
