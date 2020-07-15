<?php

namespace App\Repositories\Interfaces;

use App\Models\Rss\Country;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ChannelRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 8): LengthAwarePaginator;

    public function getInternational(): Collection;

    public function getByCountry(Country $country);
}
