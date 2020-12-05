<?php

namespace App\Repositories;

use App\Models\Rss\Post;
use Cache;
use Modules\Frontend\Http\Resources\ArticleCollection;
use App\Models\Rss\Category;
use App\Models\Rss\Channel;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    protected $fields = ['id', 'slug', 'title', 'excerpt', 'source', 'created_at'];

    protected $with = ['imageMedia'];

    public function getHot(): array
    {
        return Cache::rememberForever('posts.hot', function () {
            return Category::find(config('frontend.hot_category'))
                ->posts()
                ->limit(8)
                ->with([...$this->with, 'country'])
                ->get(array_map(fn($f) => "rss_posts.$f", [...$this->fields, 'channel_id']))
                ->all();
        });
    }

    public function getCovid(): array
    {
        return Cache::rememberForever('posts.covid', function () {
            return Category::find(config('frontend.covid_category'))
                ->posts()
                ->limit(8)
                ->with([...$this->with, 'country'])
                ->get(array_map(fn($f) => "rss_posts.$f", [...$this->fields, 'channel_id']))
                ->all();
        });
    }

    public function getByChannel(Channel $channel): ArticleCollection
    {
        $posts = $channel->posts()
            ->select($this->fields)
            ->with($this->with)
            ->paginate(4, null, null, $this->page());

        return new ArticleCollection($posts);
    }

    public function getByCategory(Category $category): ArticleCollection
    {
        $posts = $category->posts()
            ->with($this->with)
            ->paginate(4, $this->fields, null, $this->page());

        return new ArticleCollection($posts);
    }

    public function search(string $query): ArticleCollection
    {
        $posts = Post::search($query)
            ->select($this->fields)
            ->with($this->with)
            ->paginate(4, null, null, $this->page());

        return new ArticleCollection($posts);
    }

    protected function page(): int
    {
        return request()->route()->parameter('page') ?? 1;
    }
}
