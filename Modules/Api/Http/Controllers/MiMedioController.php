<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Rss\Category;
use App\Models\Rss\Channel;
use App\Models\Rss\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Modules\Api\Http\Resources\ChannelResource;
use Modules\Api\Http\Resources\PostResource;

class MiMedioController extends Controller
{
    public function categories(): Collection
    {
        return Category::all(['id', 'name']);
    }

    public function category(Request $request, Category $category): AnonymousResourceCollection
    {
        $params = $this->validate($request, [
            'limit' => ['nullable', 'numeric', 'min:1'],
            'offset' => ['nullable', 'numeric', 'min:0'],
        ]);

        $posts = $category->posts()
            ->with('imageMedia')
            ->when(isset($params['limit']), fn(Builder $q) => $q->limit($params['limit']))
            ->when(isset($params['offset']), fn(Builder $q) => $q->offset($params['offset']))
            ->get(array_map(fn($f) => "rss_posts.$f", ['id', 'source', 'title', 'slug', 'excerpt', 'created_at']));

        $count = $category->posts()->count();

        return PostResource::collection($posts)->additional(['count' => $count]);
    }

    public function channels(Request $request): AnonymousResourceCollection
    {
        $international = setting('international_medias');

        $channels = Channel::ordered()
            ->whereIn('id', $international)
            ->with(['logoMedia', 'country', 'posts' => function (Relation $posts) {
                $posts->select(['channel_id', 'id', 'title', 'slug', 'excerpt', 'source', 'created_at'])->limit(6);
            }])
            ->get(['id', 'slug', 'country_id', 'slug', 'name']);

        return ChannelResource::collection($channels);
    }

    public function post(Post $post): JsonResponse
    {
        return app(PostController::class)->show($post);
    }
}
