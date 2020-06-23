<?php

namespace App\Services;

use App\Http\Resources\ArticleCollection;
use App\Models\Article;

class ArticlesService
{
    public function getIndex()
    {
        $articles = Article::published()
            ->select(['id', 'slug', 'title', 'excerpt', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->paginate(4);

        return new ArticleCollection($articles);
    }

    public function getSidebar()
    {
        $articles = Article::published()
            ->select(['id', 'slug', 'title', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->limit(2)
            ->get();

        return new ArticleCollection($articles);
    }

    public function get404()
    {
        $articles = Article::published()
            ->select(['id', 'slug', 'title', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->limit(8)
            ->get();

        return new ArticleCollection($articles);
    }

    public function shareForCRUD()
    {
        $statuses = collect(Article::$statuses)->map(fn($val, $key) => ['value' => $key, 'label' => $val])->values();

        share([
            'statuses' => $statuses
        ]);
    }
}
