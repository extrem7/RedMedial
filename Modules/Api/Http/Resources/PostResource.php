<?php

namespace Modules\Api\Http\Resources;

use App\Models\Rss\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        /* @var $channel Post */
        $channel = $this->resource;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'excerpt' => $this->when(isset($this->excerpt), $this->excerpt),
            'date' => $this->created_at,
            'link' => $this->when(isset($this->slug), fn() => $this->link),
            'thumbnail' => $this->thumbnail,
        ];
    }
}
