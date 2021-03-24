<?php

/**
 * @apiDefine Post
 * @apiSuccess {Number} id Post id.
 * @apiSuccess {String} title Post title.
 * @apiSuccess {String} excerpt Post excerpt.
 * @apiSuccess {Date} date Post date.
 * @apiSuccess {String} link Post link.
 * @apiSuccess {String} thumbnail Post thumbnail.
 */

namespace Modules\Api\Http\Controllers;

use App\Models\Rss\Channel;
use App\Models\Rss\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Api\Http\Resources\CountryResource;
use Modules\Api\Http\Resources\PostResource;

/**
 * @group Posts
 */
class PostController extends Controller
{
    /**
     * @api {get} /posts List of posts
     * @apiName GetPosts
     * @apiGroup Posts
     *
     * @apiParam {Number} [limit] Number of posts to load.
     * @apiParam {Number} [offset] Offset of posts.
     * @apiParam {Number} [channel_id] Posts channel id.
     *
     * @apiUse Post
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $params = $this->validate($request, [
            'limit' => ['nullable', 'numeric', 'min:1'],
            'offset' => ['nullable', 'numeric', 'min:0'],
            'channel_id' => ['nullable', 'numeric', 'exists:rss_channels,id']
        ]);

        $limit = $params['limit'] ?? 6;

        $posts = Post::with('imageMedia')
            ->when(isset($params['offset']), fn(Builder $q) => $q->offset($params['offset']))
            ->when(isset($params['channel_id']), fn(Builder $q) => $q->where('channel_id', $params['channel_id']))
            ->limit($limit)
            ->get(['id', 'slug', 'title', 'excerpt', 'source', 'created_at']);

        if (isset($params['channel_id'])) {
            $channel = Channel::find($params['channel_id']);
            $posts->transform(function (Post $post) use ($channel) {
                $post->setRelation('country', $channel->country);
                return $post;
            });
        }


        return PostResource::collection($posts);
    }

    /**
     * @api {get} /posts/search Search for posts
     * @apiName SearchPosts
     * @apiGroup Posts
     *
     * @apiParam {String} query Search query string.
     * @apiParam {Number} [limit] Number of posts to load.
     * @apiParam {Number} [offset] Offset of posts.
     *
     * @apiUse Post
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $params = $this->validate($request, [
            'query' => ['required', 'string'],
            'limit' => ['nullable', 'numeric', 'min:1'],
            'offset' => ['nullable', 'numeric', 'min:0'],
        ]);

        $limit = $params['limit'] ?? 6;

        $posts = Post::search($params['query'])
            ->when(isset($params['offset']), fn(Builder $q) => $q->offset($params['offset']))
            ->limit($limit)
            ->with('imageMedia')
            ->get(['id', 'slug', 'title', 'excerpt', 'source', 'created_at']);

        return PostResource::collection($posts);
    }

    /**
     * @api {get} /posts/:id Get post by id
     * @apiName GetPost
     * @apiGroup Posts
     *
     * @apiParam {Number} id Post unique ID.
     *
     * @apiSuccess {String} title Post title.
     * @apiSuccess {String} body Post body.
     * @apiSuccess {Date} date Post date.
     * @apiSuccess {String} link Post link.
     * @apiSuccess {String} image Post image.
     * @apiSuccess {String} previous Previous post id.
     * @apiSuccess {String} next Next post id.
     */
    public function show(Post $post): JsonResponse
    {
        $previous = Post::whereChannelId($post->channel_id)->where('id', '<', $post->id)->max('id');
        $next = Post::whereChannelId($post->channel_id)->where('id', '>', $post->id)->min('id');

        return response()->json([
            'title' => $post->title,
            'body' => $post->body,
            'date' => $post->created_at,
            'link' => $post->link,
            'image' => $post->image,
            'country' => $post->country ? new CountryResource($post->country) : null,
            'previous' => $previous,
            'next' => $next,
        ]);
    }
}
