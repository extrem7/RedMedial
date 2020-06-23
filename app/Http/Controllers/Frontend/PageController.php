<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;

class PageController extends Controller
{
    public function home()
    {
        $this->seo()->setTitle('Home');

        $articles = Article::published()
            ->select(['id', 'slug', 'title', 'excerpt', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->limit(3)
            ->get();

        $articles = [
            'main' => $articles[0],
            'column' => $articles->slice(1)
        ];

        return view('frontend.pages.home.page', compact('articles'));
    }
}
