<?php

namespace Modules\Api\Http\Resources;

use App\Models\Rss\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        /* @var $country Country */
        $country = $this->resource;

        return [
            'id' => $country->id,
            'name' => $country->name,
        ];
    }
}
