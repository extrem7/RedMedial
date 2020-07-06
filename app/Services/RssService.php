<?php

namespace App\Services;

use App\Http\Resources\ArticleCollection;
use App\Models\Rss\Channel;
use App\Models\Rss\Country;
use Illuminate\Support\Collection;

class RssService
{
    public function getLocalChannels(): Collection
    {
        return $this->transformChannels(
            Channel::with($this->getChannelsRelations())->get($this->getChannelsColumns())
        );
    }

    public function getCountryChannels(Country $country): Collection
    {
        return $this->transformChannels(
            $country->channels()->with($this->getChannelsRelations())->get($this->getChannelsColumns())
        );
    }

    public function getChannelPosts(Channel $channel): ArticleCollection
    {
        $posts = $channel->posts()
            ->select(['id', 'slug', 'title', 'excerpt', 'created_at'])
            ->orderByDesc('id')
            ->with('imageMedia')
            ->paginate(4);

        return new ArticleCollection($posts);
    }

    protected function transformChannels(Collection $channels)
    {
        return $channels->transform(function (Channel $channel) {
            $channel->append('logo');
            return $channel;
        });
    }

    protected function getChannelsRelations()
    {
        return ['logoMedia', 'posts' => function ($posts) {
            $posts->select(['channel_id', 'slug', 'title'])->limit(6);
        }];
    }

    protected function getChannelsColumns()
    {
        return ['id', 'slug', 'name', 'link'];
    }
}
