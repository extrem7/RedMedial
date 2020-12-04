<?php

namespace Modules\Frontend\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;

class IframeController extends Controller
{
    public function news(PostRepositoryInterface $postRepository)
    {
        $hot = $postRepository->getCovid();

        return view('frontend::pages.home.includes.hot-news', compact('hot'), [
            'iframe' => true,
            'covid' => true,
            'title' => 'Latest Coronavirus News'
        ]);
    }

    public function map()
    {
        return view('frontend::pages.home.includes.covid-map', ['iframe' => true]);
    }
}
