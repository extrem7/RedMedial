<?php

namespace App\Repositories;

use App\Http\Resources\ArticleCollection;
use App\Models\Rss\Category;
use App\Models\Rss\Channel;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function getCovid(): array
    {
        return \Cache::rememberForever('posts.covid', function () {
            return Category::find(config('redmedial.covid_category'))
                ->posts()
                ->orderByDesc('id')
                ->limit(8)
                ->with('imageMedia', 'channel.country')
                ->get(['rss_posts.id', 'rss_posts.channel_id', 'rss_posts.slug', 'rss_posts.title', 'rss_posts.created_at'])
                ->all();
        });
    }

    public function getByChannel(Channel $channel, int $page = 1): ArticleCollection
    {
        $posts = $channel->posts()
            ->select(['id', 'slug', 'title', 'excerpt', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->paginate(4, null, null, $page);

        return new ArticleCollection($posts);
    }

    public function cacheCovid(): void
    {
        \Cache::delete('posts.covid');
        $this->getCovid();
    }
}
