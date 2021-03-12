<?php

namespace Modules\Frontend\Http\Controllers\Account;

use App\Models\Rss\Category;
use App\Models\Rss\Country;
use Inertia\Response;
use Modules\Frontend\Http\Controllers\Controller;

class RssController extends Controller
{
    public function __invoke(): Response
    {
        $this->seo()->setTitle('Rss categories room');

        $countries = Country::select(['id', 'name', 'slug'])->ordered()->get();
        $topics = Category::select(['id', 'name', 'slug'])->get();

        $categories = [
            [
                'title' => 'Countries',
                'feeds' => $countries->map(fn(Country $c) => [
                    'name' => $c->name,
                    'link' => route('frontend.feeds.country', $c->slug)
                ])->toArray()
            ],
            [
                'title' => 'Topics',
                'feeds' => $topics->map(fn(Category $c) => [
                    'name' => $c->name,
                    'link' => route('frontend.feeds.topic', $c->slug)
                ])->toArray()
            ]
        ];

        return inertia('RssRoom', compact('categories'));
    }
}
