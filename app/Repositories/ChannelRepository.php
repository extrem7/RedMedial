<?php

namespace App\Repositories;

use App\Models\Rss\Channel;
use App\Models\Rss\Country;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ChannelRepository implements ChannelRepositoryInterface
{
    public function all(): Collection
    {
        return $this->transformChannels(
            Channel::with($this->getChannelsRelations())->get($this->getChannelsColumns())
        );
    }

    public function paginate(int $perPage = 8): LengthAwarePaginator
    {
        $channels = Channel::with($this->getChannelsRelations())
            ->select($this->getChannelsColumns())
            ->paginate($perPage);

        $channels->transform(fn($channel) => $this->transformChannel($channel));

        return $channels;
    }

    public function getInternational(): Collection
    {
        return \Cache::rememberForever('channels.international', function () {
            $international = setting('international_medias');
            return $this->transformChannels(
                Channel::whereIn('id', $international)
                    ->with($this->getChannelsRelations())
                    ->get($this->getChannelsColumns())
            );
        });
    }

    public function getByCountry(Country $country): Collection
    {
        return $this->transformChannels(
            $country->channels()->with($this->getChannelsRelations())->get($this->getChannelsColumns())
        );
    }

    public function transformChannels(Collection $channels)
    {
        return $channels->transform(fn($channel) => $this->transformChannel($channel));
    }

    public function transformChannel(Channel $channel)
    {
        $channel->append('logo');
        return $channel;
    }

    public function getChannelsRelations(): array
    {
        return ['logoMedia', 'posts' => function ($posts) {
            $posts->select(['channel_id', 'slug', 'title'])->limit(6);
        }];
    }

    public function getChannelsColumns(): array
    {
        return ['id', 'slug', 'name', 'link'];
    }
}
