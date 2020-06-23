<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;
use App\Services\ArticlesService;

class ArticleController extends Controller
{
    public function index(ArticlesService $articlesService)
    {
        $this->seo()->setTitle('Blog');

        $articles = $articlesService->getIndex();

        if (request()->expectsJson()) {
            return $articles;
        } else {
            share(compact('articles'));
        }

        $articlesInSidebar = $articlesService->getSidebar();

        return view('frontend.articles.index', compact('articlesInSidebar'));
    }

    public function show(Article $article)
    {
        $this->seo()->setTitle($article->title);

        return view('frontend.articles.show', compact('article'));
    }
}
