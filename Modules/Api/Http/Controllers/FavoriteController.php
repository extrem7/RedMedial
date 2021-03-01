<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Article;
use App\Models\Rss\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Api\Http\Resources\ChannelResource;
use Modules\Api\Http\Resources\PostResource;

/**
 * @group Favorites
 */
class FavoriteController extends Controller
{
    /**
     * @api {get} /channels/favorite Favorites channels
     * @apiName GetFavoritesChannels
     * @apiGroup Favorites
     *
     * @apiParam {Number} [posts_limit] Number of posts to load for each channel.
     *
     * @apiSuccess {String} id Article id.
     * @apiSuccess {String} title Article title.
     * @apiSuccess {String} excerpt Article excerpt.
     * @apiSuccess {Date} date Article date.
     * @apiSuccess {String} link Article link.
     * @apiSuccess {String} thumbnail Article thumbnail.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $params = $this->validate($request, [
            'posts_limit' => ['nullable', 'numeric', 'min:1'],
        ]);

        /* @var $user User */
        $user = $request->user();
        $favorite = $user->favorite->pluck('channel_id');

        $channels = Channel::ordered()
            ->whereIn('id', $favorite)
            ->with(['logoMedia', 'posts' => function (Relation $posts) use ($params) {
                $posts->select(['channel_id', 'id', 'title', 'created_at'])->limit($params['posts_limit'] ?? 6);
            }])
            ->get(['id', 'name']);

        return ChannelResource::collection($channels);
    }

    /**
     * @api {post} /channels/favorite/:id Toggle favorite channel
     * @apiName ToggleFavoritesChannel
     * @apiGroup Favorites
     *
     * @apiParam {Number} id Channel unique ID.
     */
    public function toggle(Request $request, Channel $channel)
    {
        /* @var $user User */
        $user = $request->user();

        if ($user->favorite()->where('channel_id', $channel->id)->exists()) {
            $user->favorite()->where('channel_id', $channel->id)->delete();
            return ['message' => "Channel '$channel->name' has been removed from favorite"];
        }

        $user->favorite()->create(['channel_id' => $channel->id]);
        return response()->json(['message' => "Channel '$channel->name' has been saved to favorite"]);
    }

}
