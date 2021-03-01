<?php

namespace Database\Seeders;

use App\Models\Rss\Country;
use Illuminate\Database\Seeder;

class RssCountriesSeeder extends Seeder
{
    public function run(): void
    {
        $countries = require(database_path('old/countries.php'));

        \DB::transaction(function () use ($countries) {
            foreach ($countries as $country) {
                Country::create([
                    'slug' => $country['slug'],
                    'name' => $country['name'],
                    'code' => $country['code'],
                    'order_column' => $country['order']
                ]);
            }
        });
    }
}
