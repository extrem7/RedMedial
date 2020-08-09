<?php

namespace App\Providers;

use App\Repositories\ArticleRepository;
use App\Repositories\ChannelRepository;
use App\Repositories\CountryRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\PlaylistRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\PlaylistRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ArticleRepositoryInterface::class,
            ArticleRepository::class
        );
        $this->app->bind(
            CountryRepositoryInterface::class,
            CountryRepository::class
        );
        $this->app->bind(
            ChannelRepositoryInterface::class,
            ChannelRepository::class
        );
        $this->app->bind(
            PostRepositoryInterface::class,
            PostRepository::class
        );
        $this->app->bind(
            PlaylistRepositoryInterface::class,
            PlaylistRepository::class
        );
    }
}
