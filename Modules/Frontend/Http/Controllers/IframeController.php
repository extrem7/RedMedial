<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Rss\Category;
use App\Repositories\Interfaces\PostRepositoryInterface;

class IframeController extends Controller
{
    private PostRepositoryInterface $postRepository;

    public function __construct()
    {
        $this->postRepository = app(PostRepositoryInterface::class);
    }

    public function hot()
    {
        $hotCategory = Category::find(config('frontend.hot_category'));
        $hot = $this->postRepository->getHot();

        return view('frontend::pages.home.includes.hot-news', compact('hotCategory', 'hot'), [
            'iframe' => true,
            'route' => 'covid.news',
            'title' => 'Latest Coronavirus News'
        ]);
    }

    public function covid()
    {
        $hot = $this->postRepository->getCovid();

        return view('frontend::pages.home.includes.hot-news', compact('hot'), [
            'iframe' => true,
            'covid' => true,
            'route' => 'covid.news',
            'title' => 'Latest Coronavirus News'
        ]);
    }

    public function map()
    {
        return view('frontend::pages.home.includes.covid-map', ['iframe' => true]);
    }
}
