<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;

class ArticleController extends Controller
{

    protected $model = Article::class;

    public function index()
    {
        $this->meta->prependTitle('Blog');

        $articles = Article::ordered()->get();

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $this->meta->prependTitle('Create a new article');

        $statuses = collect(Article::$statuses)->map(fn($val, $key) => ['value' => $key, 'label' => $val])->values();

        share([
            'statuses' => $statuses
        ]);

        return view('articles.create');
    }

    public function store(ArticleRequest $request)
    {
        $article = new Article($request->input());

        if ($request->hasFile('image')) {
            $article->uploadImage($request->file('image'));
        }

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
        share(compact('article'));
        return view('articles.edit');
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->input());
        $article->save();

        if ($request->hasFile('image')) {
            $article->uploadImage($request->file('image'));
        }

        return response()->json(['status' => 'Article has been updated'], 204);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['status' => 'Article has been deleted'], 204);
    }
}
