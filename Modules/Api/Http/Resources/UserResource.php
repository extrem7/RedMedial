<?php

namespace Modules\Api\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        /* @var $user User */
        $user = $this->resource;
        $user->append('icon');

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            $this->mergeWhen($user->relationLoaded('information'), fn() => [
                'bio' => $user->information->bio,
                'settings' => json_decode($user->information->settings),
            ]),
            'avatar' => $user->icon,
            'country' => $this->when(
                $user->relationLoaded('information') && $user->information->relationLoaded('country'),
                fn() => new CountryResource($user->information->country)
            ),
        ];
    }
}
