<?php

namespace App\Repositories\Interfaces;

use App\Models\Rss\Country;
use Illuminate\Support\Collection;

interface CountryRepositoryInterface
{
    public function getForHeader(): Collection;

    public function getByCode(string $code = null): ?Country;

    public function cacheForHeader(): void;

    public function cacheByCode(string $code = null): void;
}
