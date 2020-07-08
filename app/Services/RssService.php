<?php

namespace App\Services;

use App\Http\Resources\ArticleCollection;
use App\Models\Rss\Channel;
use App\Models\Rss\Country;
use Illuminate\Support\Collection;

class RssService
{
    public function getAll(): Collection
    {
        return $this->transformChannels(
            Channel::with($this->getChannelsRelations())->get($this->getChannelsColumns())
        );
    }

    public function getCountry(string $code = null): ?Country
    {
        $that = $this;

        $country = Country::whereCode($code)
            ->with(['channels' => function ($channels) use ($that) {
                $channels->with($that->getChannelsRelations())->select(['country_id', ...$that->getChannelsColumns()]);
            }])
            ->first();
        if ($country !== null)
            $country->channels->transform(fn($channel) => $this->transformChannel($channel));

        return $country;
    }

    public function getInternationalChannels(): Collection
    {
        $international = explode(',', setting('international_medias'));

        return $this->transformChannels(
            Channel::whereIn('id', $international)
                ->with($this->getChannelsRelations())
                ->get($this->getChannelsColumns())
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
        return $channels->transform(fn($channel) => $this->transformChannel($channel));
    }

    protected function transformChannel(Channel $channel)
    {
        $channel->append('logo');
        return $channel;
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
