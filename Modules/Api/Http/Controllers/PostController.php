<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Rss\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
     * @apiSuccess {String} id Post id.
     * @apiSuccess {String} title Post title.
     * @apiSuccess {String} excerpt Post excerpt.
     * @apiSuccess {Date} date Post date.
     * @apiSuccess {String} link Post link.
     * @apiSuccess {String} thumbnail Post thumbnail.
     */
    public function index(Request $request)
    {
        $params = $this->validate($request, [
            'limit' => ['nullable', 'numeric', 'min:1'],
            'offset' => ['nullable', 'numeric', 'min:0'],
            'channel_id' => ['nullable', 'numeric', 'exists:rss_channels,id']
        ]);

        $posts = Post::when(isset($params['limit']), fn(Builder $q) => $q->limit($params['limit']))
            ->when(isset($params['offset']), fn(Builder $q) => $q->offset($params['offset']))
            ->when(isset($params['channel_id']), fn(Builder $q) => $q->where('channel_id', $params['channel_id']))
            ->with('imageMedia')
            ->get(['id', 'slug', 'title', 'excerpt', 'created_at']);

        return PostResource::collection($posts)->toArray($request);
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
    public function show(Post $post)
    {
        $previous = Post::whereChannelId($post->channel_id)->where('id', '<', $post->id)->max('id');
        $next = Post::whereChannelId($post->channel_id)->where('id', '>', $post->id)->min('id');

        return [
            'title' => $post->title,
            'body' => $post->body,
            'date' => $post->created_at,
            'link' => $post->link,
            'image' => $post->image,
            'previous' => $previous,
            'next' => $next,
        ];
    }
}
