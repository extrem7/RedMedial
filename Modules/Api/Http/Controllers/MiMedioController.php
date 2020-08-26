<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Rss\Category;
use App\Models\Rss\Channel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Modules\Api\Http\Resources\ChannelResource;
use Modules\Api\Http\Resources\PostResource;

class MiMedioController extends Controller
{
    public function categories()
    {
        $categories = Category::all(['id', 'name']);
        return $categories;
    }

    public function category(Request $request, Category $category)
    {
        $params = $this->validate($request, [
            'limit' => ['nullable', 'numeric', 'min:1'],
            'offset' => ['nullable', 'numeric', 'min:0'],
        ]);

        $posts = $category->posts()
            ->with('imageMedia')
            ->when(isset($params['limit']), fn(Builder $q) => $q->limit($params['limit']))
            ->when(isset($params['offset']), fn(Builder $q) => $q->offset($params['offset']))
            ->get(['rss_posts.id', 'rss_posts.source', 'rss_posts.title', 'rss_posts.excerpt', 'rss_posts.created_at']);

        $count = $category->posts()->count();

        return PostResource::collection($posts)->additional(['count' => $count]);
    }

    public function channels(Request $request)
    {
        $international = setting('international_medias');

        $channels = Channel::ordered()
            ->whereIn('id', $international)
            ->with(['logoMedia', 'country', 'posts' => function (Relation $posts) {
                $posts->select(['channel_id', 'id', 'title', 'excerpt', 'source', 'created_at'])->limit(6);
            }])
            ->get(['id', 'country_id', 'name']);

        return ChannelResource::collection($channels);
    }
}
