<?php

namespace Modules\Admin\Services;

use App\Models\Rss\Country;
use App\Models\Rss\Language;

class ChannelsService
{
    public function getCountries()
    {
        return Country::all()->pluck('name', 'id');
    }

    public function getLanguages()
    {
        return Language::all()->pluck('name', 'id');
    }

    public function shareForCRUD()
    {
        $countries = collect($this->getCountries())
            ->map(fn($val, $key) => ['value' => $key, 'label' => ucfirst($val)])->values();

        $languages = collect($this->getLanguages())
            ->map(fn($val, $key) => ['value' => $key, 'label' => ucfirst($val)])->values();

        share(compact('countries', 'languages'));
    }
}
