<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Modules\Admin\Http\Requests\ArticleRequest;
use Modules\Admin\Http\Requests\IndexRequest;

class ArticleController extends Controller
{
    protected ArticleRepositoryInterface $articleRepository;

    public function __construct()
    {
        $this->articleRepository = app(ArticleRepositoryInterface::class);
    }

    public function index(IndexRequest $request)
    {
        $this->seo()->setTitle('Blog');

        $sort = $request->get('sortDesc') ?? true;

        $articles = Article::query()->select(['id', 'slug', 'title', 'status', 'created_at', 'updated_at'])
            ->when($request->get('searchQuery'), fn($q) => $q->search($request->get('searchQuery')))
            ->orderBy($request->get('sortBy') ?? 'id', $sort ? 'desc' : 'asc')
            ->paginate(10);

        $articles->getCollection()->transform(function ($article) {
            $article['status'] = Article::$statuses[$article['status']];
            $article['link'] = route('frontend.articles.show', $article->slug);
            return $article;
        });
        if (request()->expectsJson()) {
            return $articles;
        } else {
            share(compact('articles'));
        }

        return view('admin::articles.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new article');

        $this->articleRepository->shareForCRUD();

        return view('admin::articles.form');
    }

    public function store(ArticleRequest $request)
    {
        $article = new Article($request->validated());

        if ($request->hasFile('image'))
            $article->uploadImage($request->file('image'));

        $article->save();
        $this->articleRepository->cacheHome();

        return response()->json([
            'status' => 'Article has been created',
            'id' => $article->id
        ], 201);
    }

    public function edit(Article $article)
    {
        $this->seo()->setTitle('Edit an article');

        $article->oldImage = $article->getImage();

        $this->articleRepository->shareForCRUD();

        share(compact('article'));

        return view('admin::articles.form');
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->validated());

        if ($request->hasFile('image')) $article->uploadImage($request->file('image'));

        $article->save();
        $article->load('imageMedia');

        $this->articleRepository->cacheHome();

        return response()->json(['status' => 'Article has been updated', 'image' => $article->getImage()]);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['status' => 'Article has been deleted']);
    }
}
