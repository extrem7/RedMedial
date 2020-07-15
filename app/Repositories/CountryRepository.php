<?php

namespace App\Repositories;

use App\Models\Rss\Country;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use Illuminate\Support\Collection;

class CountryRepository implements CountryRepositoryInterface
{
    protected ChannelRepositoryInterface $channelRepository;

    public function __construct()
    {
        $this->channelRepository = app(ChannelRepositoryInterface::class);
    }

    public function getForHeader(): Collection
    {
        return \Cache::rememberForever('countries.header', function () {
            return Country::ordered()->pluck('name', 'slug');
        });
    }

    public function getByCode(string $code = null): ?Country
    {
        return \Cache::rememberForever("country.$code", function () use ($code) {
            $country = Country::whereCode($code)
                ->with(['channels' => function ($channels) {
                    $channels->with(
                        $this->channelRepository->getChannelsRelations())
                        ->select(['country_id', ...$this->channelRepository->getChannelsColumns()])
                        ->limit(8);
                }])
                ->first();
            if ($country !== null)
                $country->channels->transform(fn($channel) => $this->channelRepository->transformChannel($channel));

            return $country;
        });
    }
}
