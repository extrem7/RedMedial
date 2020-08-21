<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Rss\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
}
