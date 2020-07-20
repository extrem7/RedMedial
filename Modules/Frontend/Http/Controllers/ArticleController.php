<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleController extends Controller
{
    protected ArticleRepositoryInterface $articleRepository;

    public function __construct()
    {
        $this->articleRepository = app(ArticleRepositoryInterface::class);
    }

    public function index(int $page = 1)
    {
        $this->seo()->setTitle('Blog');

        $articles = $this->articleRepository->getIndex($page);

        abort_if($articles->collection->isEmpty(), 404);

        if (request()->expectsJson()) {
            return $articles;
        } else {
            share(compact('articles'));
        }

        return view('frontend::articles.index');
    }

    public function show(Article $article)
    {
        $this->seo()->setTitle($article->meta_title ?? $article->title);
        $this->seo()->setDescription($article->meta_description ?? strip_tags($article->excerpt));
        if ($article->imageMedia) $this->seo()->addImages(url($article->getImage()));

        return view('frontend::articles.show', compact('article'));
    }
}
