<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\Api\Http\Resources\PostResource;

/**
 * @group Articles
 */
class ArticleController extends Controller
{
    /**
     * @api {get} /blog List of blog articles
     * @apiName GetArticles
     * @apiGroup Articles
     *
     * @apiParam {Number} [limit] Number of articles to load.
     * @apiParam {Number} [offset] Offset of articles.
     *
     * @apiSuccess {String} id Article id.
     * @apiSuccess {String} title Article title.
     * @apiSuccess {String} excerpt Article excerpt.
     * @apiSuccess {Date} date Article date.
     * @apiSuccess {String} link Article link.
     * @apiSuccess {String} thumbnail Article thumbnail.
     */
    public function index(Request $request)
    {
        $params = $this->validate($request, [
            'limit' => ['nullable', 'numeric', 'min:1'],
            'offset' => ['nullable', 'numeric', 'min:0'],
            'channel_id' => ['nullable', 'numeric', 'exists:rss_channels,id']
        ]);

        $articles = Article::orderByDesc('created_at')
            ->when(isset($params['limit']), fn(Builder $q) => $q->limit($params['limit']))
            ->when(isset($params['offset']), fn(Builder $q) => $q->offset($params['offset']))
            ->with('imageMedia')
            ->get(['id', 'slug', 'title', 'excerpt', 'created_at']);

        return PostResource::collection($articles)->toArray($request);
    }

    /**
     * @api {get} /articles/:id Get article by id
     * @apiName GetArticle
     * @apiGroup Articles
     *
     * @apiParam {Number} id article unique ID.
     *
     * @apiSuccess {String} title Article title.
     * @apiSuccess {String} body Article body.
     * @apiSuccess {Date} date Article date.
     * @apiSuccess {String} link Article link.
     * @apiSuccess {String} image Article image.
     * @apiSuccess {String} previous Previous article id.
     * @apiSuccess {String} next Next article id.
     */
    public function show(Article $article)
    {
        $previous = Article::where('id', '<', $article->id)->max('id');
        $next = Article::where('id', '>', $article->id)->min('id');

        return [
            'title' => $article->title,
            'body' => $article->body,
            'date' => $article->created_at,
            'link' => $article->link,
            'image' => $article->image,
            'previous' => $previous,
            'next' => $next,
        ];
    }
}
