<?php

namespace App\Services;

use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Cache;

class CacheService
{
    protected ArticleRepositoryInterface $articleRepository;

    protected CountryRepositoryInterface $countryRepository;

    protected ChannelRepositoryInterface $channelRepository;

    protected PostRepositoryInterface $postRepository;

    public function __construct()
    {
        $this->articleRepository = app(ArticleRepositoryInterface::class);
        $this->countryRepository = app(CountryRepositoryInterface::class);
        $this->channelRepository = app(ChannelRepositoryInterface::class);
        $this->postRepository = app(PostRepositoryInterface::class);
    }

    public function articlesHome(): void
    {
        Cache::delete('articles.home');
        $this->articleRepository->getHome();
    }

    public function countiesForHeader(): void
    {
        \Cache::delete('countries.header');
        $this->countryRepository->getForHeader();
    }

    public function countyByCode(string $code = null): void
    {
        \Cache::delete("country.$code");
        $this->countryRepository->getByCode($code);
    }

    public function channelsInternational(): void
    {
        \Cache::delete('channels.international');
        $this->channelRepository->getInternational();
    }

    public function postsCovid(): void
    {
        \Cache::delete('posts.covid');
        $this->postRepository->getCovid();
    }
}
