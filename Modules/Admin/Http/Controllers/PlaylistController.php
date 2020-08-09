<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Playlist;
use Cacher;
use Modules\Admin\Http\Requests\PlaylistRequest;
use Modules\Admin\Http\Requests\Rss\SortRequest;
use Modules\Admin\Services\ChannelsService;

class PlaylistController extends Controller
{

    protected ChannelsService $channelsService;

    public function __construct()
    {
        $this->channelsService = app(ChannelsService::class);
    }

    public function index()
    {
        $this->seo()->setTitle('Playlists');

        $playlists = Playlist::ordered()->get(['id', 'title', 'created_at', 'updated_at']);

        share(compact('playlists'));

        return view('admin::playlists.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new playlist');

        $this->channelsService->shareForCRUD();

        return view('admin::playlists.form');
    }

    public function store(PlaylistRequest $request)
    {
        $playlist = new Playlist($request->validated());
        $playlist->save();

        return response()->json([
            'status' => 'Playlist has been created',
            'id' => $playlist->id
        ], 201);
    }

    public function edit(Playlist $playlist)
    {
        $this->seo()->setTitle('Edit a playlist');

        $this->channelsService->shareForCRUD();
        share(compact('playlist'));

        return view('admin::playlists.form');
    }

    public function update(PlaylistRequest $request, Playlist $playlist)
    {
        $playlist->update($request->validated());

        return response()->json(['status' => 'Playlist has been updated', 'playlist' => $playlist]);
    }

    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return response()->json(['status' => 'Playlist has been deleted']);
    }

    public function sort(SortRequest $request)
    {
        $order = $request->input('order');
        Playlist::setNewOrder($order);
        Cacher::playlistsHome();
        return response()->json(['status' => 'Playlists has been sorted']);
    }
}
