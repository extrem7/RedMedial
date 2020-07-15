<?php

namespace App\Repositories;

use Modules\Frontend\Http\Resources\ArticleCollection;
use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Cache;
use Illuminate\Support\Collection;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function getIndex(int $page = 1): ArticleCollection
    {
        $articles = Article::published()
            ->select(['id', 'slug', 'title', 'excerpt', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->paginate(4, null, null, $page);

        return new ArticleCollection($articles);
    }

    public function getHome(): array
    {
        return Cache::rememberForever('articles.home', function () {
            $articles = Article::published()
                ->select(['id', 'slug', 'title', 'excerpt', 'created_at'])
                ->orderByDesc('id')
                ->with('imageMedia')
                ->limit(3)
                ->get();

            return [
                'main' => $articles[0],
                'column' => $articles->slice(1)
            ];
        });
    }

    public function getSidebar(): ArticleCollection
    {
        $articles = Article::published()
            ->select(['id', 'slug', 'title', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->limit(2)
            ->get();

        return new ArticleCollection($articles);
    }

    public function get404(): Collection
    {
        return Article::published()
            ->select(['id', 'slug', 'title', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->limit(8)
            ->get();
    }

    public function shareForCRUD(): void
    {
        $statuses = collect(Article::$statuses)->map(fn($val, $key) => ['value' => $key, 'label' => $val])->values();

        share([
            'statuses' => $statuses
        ]);
    }
}
