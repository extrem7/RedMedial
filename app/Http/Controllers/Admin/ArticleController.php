<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use App\Services\ArticlesService;

class ArticleController extends Controller
{
    protected ArticlesService $articleService;

    public function __construct()
    {
        parent::__construct();
        $this->articleService = app(ArticlesService::class);
    }

    public function index()
    {
        $this->meta->prependTitle('Blog');

        $articles = Article::select(['id', 'title', 'created_at', 'updated_at'])
            ->orderByDesc('id')
            ->paginate(1);

        if (request()->expectsJson()) {
            return $articles;
        }

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $this->meta->prependTitle('Create a new article');

        $this->articleService->shareForCRUD();

        return view('articles.create');
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
        $this->meta->prependTitle('Edit an article');

        $article->append('image');

        $this->articleService->shareForCRUD();

        share(compact('article'));

        return view('articles.edit');
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->input());

        if ($slug = $request->get('slug'))
            if ($article->slug !== $slug)
                $article->setSlug($slug);

        if ($request->hasFile('image')) $article->uploadImage($request->file('image'));

        $article->save();

        return response()->json(['status' => 'Article has been updated'], 200);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['status' => 'Article has been deleted'], 200);
    }
}
