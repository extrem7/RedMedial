<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ArticleRequest;
use App\Http\Requests\Admin\IndexRequest;
use App\Models\Article;
use App\Services\ArticlesService;

class ArticleController extends Controller
{
    protected ArticlesService $articleService;

    public function __construct()
    {
        $this->articleService = app(ArticlesService::class);
    }

    public function index(IndexRequest $request)
    {
        $this->seo()->setTitle('Blog');

        $sort = $request->get('sortDesc') ?? true;

        $articles = Article::query()->select(['id', 'title', 'status', 'created_at', 'updated_at'])
            ->when($request->get('searchQuery'), fn($q) => $q->search($request->get('searchQuery')))
            ->orderBy($request->get('sortBy') ?? 'id', $sort ? 'desc' : 'asc')
            ->paginate(10);

        $articles->getCollection()->transform(function ($article) {
            $article['status'] = Article::$statuses[$article['status']];
            return $article;
        });
        if (request()->expectsJson()) {
            return $articles;
        } else {
            share(compact('articles'));
        }

        return view('admin.articles.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new article');

        $this->articleService->shareForCRUD();

        return view('admin.articles.create');
    }

    public function store(ArticleRequest $request)
    {
        $article = new Article($request->input());

        if ($slug = $request->get('slug')) $article->setSlug($slug);

        if ($request->hasFile('image')) $article->uploadImage($request->file('image'));

        $article->save();

        return response()->json([
            'status' => 'Article has been created',
            'id' => $article->id
        ], 201);
    }

    public function edit(Article $article)
    {
        $this->seo()->setTitle('Edit an article');

        $article->oldImage = $article->getImage();

        $this->articleService->shareForCRUD();

        share(compact('article'));

        return view('admin.articles.edit');
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->input());

        if ($slug = $request->get('slug'))
            if ($article->slug !== $slug)
                $article->setSlug($slug);

        if ($request->hasFile('image')) $article->uploadImage($request->file('image'));

        $article->save();
        $article->load('imageMedia');

        return response()->json(['status' => 'Article has been updated', 'image' => $article->getImage()]);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['status' => 'Article has been deleted']);
    }
}
