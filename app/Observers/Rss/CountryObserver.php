<?php

namespace App\Observers\Rss;

use App\Repositories\Interfaces\CountryRepositoryInterface;

class CountryObserver
{
    protected CountryRepositoryInterface $countryRepository;

    public function __construct()
    {
        $this->countryRepository = app(CountryRepositoryInterface::class);
    }

    public function created()
    {
        $this->countryRepository->cacheForHeader();
    }

    public function updated()
    {
        $this->countryRepository->cacheForHeader();
    }

    public function deleted()
    {
        $this->countryRepository->cacheForHeader();
    }
}
