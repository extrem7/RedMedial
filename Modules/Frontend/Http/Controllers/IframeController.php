<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Rss\Category;
use App\Models\Rss\Country;
use App\Models\Rss\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Frontend\Http\Resources\ArticleCollection;

class IframeController extends Controller
{
    private PostRepositoryInterface $postRepository;

    public function __construct()
    {
        $this->postRepository = app(PostRepositoryInterface::class);
    }

    public function custom(Request $request): View
    {
        $options = $this->validate($request, [
            'language' => ['nullable', 'exists:rss_languages,slug'],
            'country' => ['nullable', 'exists:rss_countries,slug'],
            'topic' => ['nullable', 'exists:rss_categories,slug'],
            'limit' => ['nullable', 'integer', 'in:4,8,12,16'],
            'title' => ['nullable', 'string'],
            'borderType' => ['nullable', 'string', 'in:solid,dashed,dotted,double'],
            'borderSize' => ['nullable', 'numeric', 'min:1', 'max:20'],
            'borderColor' => ['nullable', 'string'],
        ]);

        $posts = Post::with(['channel.country', 'imageMedia'])
            ->when($request->filled('language'), fn($q) => $q->whereHas(
                'channel', fn($q) => $q->whereHas('language', fn($q) => $q->where('slug', '=', $options['language']))
            ))
            ->when($request->filled('country'), fn($q) => $q->whereHas(
                'channel', fn($q) => $q->whereHas('country', fn($q) => $q->where('slug', '=', $options['country']))
            ))
            ->when($request->filled('topic'), fn($q) => $q->whereHas(
                'categories', fn($q) => $q->where('slug', '=', $options['topic'])
            ))
            ->limit($options['limit'] ?? 4)
            ->get(['id', 'channel_id', 'title', 'slug', 'source', 'created_at']);

        if (!count($posts)) {
            abort(404);
        }

        share(array_merge(compact('options'), [
            'posts' => ArticleCollection::make($posts)->collection
        ]));

        return view('frontend::pages.iframe');
    }

    public function hot(): View
    {
        $hotCategory = Category::find(config('frontend.hot_category'));
        $hot = $this->postRepository->getHot();

        return view('frontend::pages.home.includes.hot-news', compact('hotCategory', 'hot'), [
            'iframe' => true,
            'route' => 'covid.news',
            'title' => 'Latest Coronavirus News'
        ]);
    }

    public function covid(): View
    {
        $hot = $this->postRepository->getCovid();

        return view('frontend::pages.home.includes.hot-news', compact('hot'), [
            'iframe' => true,
            'covid' => true,
            'route' => 'covid.news',
            'title' => 'Latest Coronavirus News'
        ]);
    }

    public function map(): View
    {
        return view('frontend::pages.home.includes.covid-map', ['iframe' => true]);
    }
}
