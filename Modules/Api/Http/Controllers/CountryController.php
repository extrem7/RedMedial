<?php

namespace Modules\Api\Http\Controllers;

use App\Models\Rss\Country;
use Torann\GeoIP\Location;

/**
 * @group  Countries
 */
class CountryController extends Controller
{
    /**
     * @api {get} /countries List of countries
     * @apiName GetCountriesLists
     * @apiGroup Countries
     *
     * @apiSuccess {Number} id Country id.
     * @apiSuccess {String} name Country name.
     *
     */
    public function index(): array
    {
        $countries = Country::ordered()->get(['id', 'name'])->map(function (Country $country) {
            return [
                'id' => $country->id,
                'name' => $country->name
            ];
        });

        return $countries->toArray();
    }

    /**
     * @api {get} /geoip GEOIP - get user country
     * @apiName GetUserCountry
     * @apiGroup Countries
     *
     * @apiSuccess {Number} id Country id.
     * @apiSuccess {String} name Country name.
     */
    public function geoip(): Country
    {
        $location = config('app.env') === 'local' ? geoip(config('frontend.local_geoip')) : geoip()->getLocation();
        if ($location instanceof Location) {
            $code = $location->iso_code;
            $country = Country::whereCode($code)->first(['id', 'name']);
            return $country;
        }
        $this->response->errorNotFound();
    }
}
