<?php

namespace Modules\Api\Http\Resources;

use App\Models\Rss\Channel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        /* @var $channel Channel */
        $channel = $this->resource;
        $channel->append('logo');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo,
            'link' => $this->when(isset($this->slug), fn() => route('frontend.rss.channels.show', $this->slug)),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
    }
}
