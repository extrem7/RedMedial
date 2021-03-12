<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Rss\Category;
use App\Models\Rss\Country;
use Spatie\Feed\Feed;

class FeedController extends Controller
{
    protected int $limit = 25;

    protected array $relations = ['channel'];

    public function language(string $language): Feed
    {
        $posts = $language->posts()->with($this->relations)->limit($this->limit)->get();
        return new Feed("Red Medial news by language: $language->name", $posts, request()->url());
    }

    public function country(Country $country): Feed
    {
        $posts = $country->posts()->with($this->relations)->limit($this->limit)->get();
        return new Feed("Red Medial news by country: $country->name", $posts, request()->url());
    }

    public function topic(Category $category): Feed
    {
        $posts = $category->posts()->with($this->relations)->limit($this->limit)->get();
        return new Feed("Red Medial news by topic: $category->name", $posts, request()->url());
    }
}
