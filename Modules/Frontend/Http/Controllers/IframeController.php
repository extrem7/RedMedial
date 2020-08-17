<?php

namespace Modules\Frontend\Http\Controllers;

use App\Repositories\Interfaces\PostRepositoryInterface;

class IframeController extends Controller
{
    public function news(PostRepositoryInterface $postRepository)
    {
        $covid = $postRepository->getCovid();

        return view('frontend::pages.home.includes.hot-news', compact('covid'), ['iframe' => true]);
    }

    public function map()
    {
        return view('frontend::pages.home.includes.covid-map', ['iframe' => true]);
    }
}
