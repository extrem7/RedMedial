<?php

namespace App\Repositories;

use App\Models\Rss\Post;
use Modules\Frontend\Http\Resources\ArticleCollection;
use App\Models\Rss\Category;
use App\Models\Rss\Channel;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function getCovid(): array
    {
        return \Cache::rememberForever('posts.covid', function () {
            return Category::find(config('frontend.covid_category'))
                ->posts()
                ->limit(8)
                ->with('imageMedia', 'channel.country')
                ->get(['rss_posts.id', 'rss_posts.channel_id', 'rss_posts.slug', 'rss_posts.title', 'rss_posts.created_at'])
                ->all();
        });
    }

    public function getByChannel(Channel $channel): ArticleCollection
    {
        $posts = $channel->posts()
            ->select(['id', 'slug', 'title', 'excerpt', 'created_at'])
            ->with('imageMedia')
            ->paginate(4, null, null, $this->page());

        return new ArticleCollection($posts);
    }

    public function search(string $query): ArticleCollection
    {
        $posts = Post::search($query)
            ->select(['id', 'slug', 'title', 'excerpt', 'created_at'])
            ->with('imageMedia')
            ->paginate(4, null, null, $this->page());

        return new ArticleCollection($posts);
    }

    protected function page(): int
    {
        return request()->route()->parameter('page') ?? 1;
    }
}
