<?php

namespace Modules\Frontend\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\View\View;
use Modules\Frontend\Http\Requests\SearchRequest;
use Modules\Frontend\Http\Resources\ArticleCollection;

class SearchController extends Controller
{
    protected PostRepositoryInterface $postRepository;

    public function __construct()
    {
        $this->postRepository = app(PostRepositoryInterface::class);
    }

    /* @return View|ArticleCollection */
    public function __invoke(SearchRequest $request, int $page = 1)
    {
        $query = $request->input('query');

        $this->seo()->setTitle($query ?? 'Search');

        $posts = $this->postRepository->search($query ?? '');

        if ($request->expectsJson()) {
            return $posts;
        }

        share(['articles' => $posts]);

        share(compact('query'));

        return view('frontend::pages.search', compact('query', 'page'));
    }
}
