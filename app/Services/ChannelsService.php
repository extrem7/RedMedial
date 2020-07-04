<?php


namespace App\Services;


use App\Models\Rss\Country;

class ChannelsService
{
    public function getCountries()
    {
        return Country::all()->pluck('name', 'id');
    }

    public function shareForCRUD()
    {
        $countries = collect($this->getCountries())
            ->map(fn($val, $key) => ['value' => $key, 'label' => ucfirst($val)])->values();

        share(compact('countries'));
    }
}
