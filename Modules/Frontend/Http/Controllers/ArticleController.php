<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Frontend\Http\Resources\ArticleCollection;
use Modules\Frontend\Services\SchemaService;

class ArticleController extends Controller
{
    protected ArticleRepositoryInterface $articleRepository;

    public function __construct()
    {
        $this->articleRepository = app(ArticleRepositoryInterface::class);
    }

    /* @return View|ArticleCollection */
    public function index(Request $request, int $page = 1)
    {
        $this->seo()->setTitle('Blog');

        $articles = $this->articleRepository->getIndex($page);

        abort_if($articles->collection->isEmpty(), 404);

        if ($request->has('api_life_hack') && $request->expectsJson()) {
            return $articles;
        }

        share(compact('articles'));

        return view('frontend::articles.index');
    }

    public function show(Article $article, SchemaService $schemaService): View
    {
        $article->load('imageMedia');
        $article->append(['image', 'link']);

        $this->seo()->setTitle($article->meta_title ?? $article->title);
        $this->seo()->setDescription($article->meta_description ?? strip_tags($article->excerpt));
        if ($article->imageMedia) {
            $this->seo()->addImages(url($article->getImage()));
        }

        share(compact('article'));

        $articleSchema = $schemaService->article($article);

        return view('frontend::articles.show', compact('article', 'articleSchema'));
    }
}
