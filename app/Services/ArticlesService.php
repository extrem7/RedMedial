<?php

namespace App\Services;

use App\Http\Resources\ArticleCollection;
use App\Models\Article;
use App\Models\Rss\Category;
use Illuminate\Support\Collection;

class ArticlesService
{
    public function getIndex(): ArticleCollection
    {
        $articles = Article::published()
            ->select(['id', 'slug', 'title', 'excerpt', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->paginate(4);

        return new ArticleCollection($articles);
    }

    public function getHome(): array
    {
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
    }

    public function getCovid(): array
    {
        return Category::find(config('redmedial.covid_category'))
            ->posts()
            ->limit(8)
            ->with('imageMedia', 'channel.country')
            ->get(['rss_posts.id', 'rss_posts.channel_id', 'rss_posts.slug', 'rss_posts.title', 'rss_posts.created_at'])
            ->all();
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
        $articles = Article::published()
            ->select(['id', 'slug', 'title', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->limit(8)
            ->get();

        return $articles;
    }

    public function shareForCRUD(): void
    {
        $statuses = collect(Article::$statuses)->map(fn($val, $key) => ['value' => $key, 'label' => $val])->values();

        share([
            'statuses' => $statuses
        ]);
    }
}
