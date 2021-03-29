<?php

namespace Modules\Frontend\Http\Controllers\Account;

use App\Models\Rss\Category;
use App\Models\Rss\Country;
use App\Models\Rss\Language;
use Inertia\Response;
use Modules\Frontend\Http\Controllers\Controller;

class RssController extends Controller
{
    public function __invoke(): Response
    {
        $this->seo()->setTitle('Rss categories room');

        $languages = Language::ordered()->get(['name', 'slug']);
        $countries = Country::ordered()->get(['name', 'slug']);
        $topics = Category::all(['name', 'slug']);

        $categories = [
            [
                'title' => 'Languages',
                'feeds' => $languages->map(fn(Language $l) => [
                    'name' => $l->name,
                    'link' => route('frontend.feeds.language', $l->slug)
                ])->toArray()
            ],
            [
                'title' => 'Countries',
                'feeds' => $countries->map(fn(Country $c) => [
                    'name' => $c->name,
                    'link' => route('frontend.feeds.country', $c->slug)
                ])->toArray()
            ],
            [
                'title' => 'Topics',
                'feeds' => $topics->map(fn(Category $t) => [
                    'name' => $t->name,
                    'link' => route('frontend.feeds.topic', $t->slug)
                ])->toArray()
            ]
        ];

        return inertia('RssRoom', compact('categories'));
    }
}
