<?php

namespace App\Observers;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleObserver
{
    protected ArticleRepositoryInterface $articleRepository;

    public function __construct()
    {
        $this->articleRepository = app(ArticleRepositoryInterface::class);
    }

    public function deleted(Article $article)
    {
        $this->articleRepository->cacheHome();
    }
}
