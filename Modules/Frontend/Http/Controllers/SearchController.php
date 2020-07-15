<?php

namespace Modules\Frontend\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Modules\Frontend\Http\Requests\SearchRequest;

class SearchController extends Controller
{
    protected PostRepositoryInterface $postRepository;

    public function __construct()
    {
        $this->postRepository = app(PostRepositoryInterface::class);
    }

    public function __invoke(SearchRequest $request, int $page = 1)
    {
        $query = $request->input('query');

        $this->seo()->setTitle($query);
        if ($query !== null) {
            $posts = $this->postRepository->search($query);

            if (request()->expectsJson()) {
                return $posts;
            } else {
                share(['articles' => $posts]);
            }
        }
        share(compact('query'));

        return view('frontend::pages.search', compact('query', 'page'));
    }
}
