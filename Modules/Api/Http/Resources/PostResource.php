<?php

namespace Modules\Api\Http\Resources;

use App\Models\Article;
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
        /* @var Post $post */
        $post = $this->resource;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'excerpt' => $this->when(isset($this->excerpt), $this->excerpt),
            'date' => $this->created_at,
            'link' => $this->source,
            'thumbnail' => $post instanceof Article ? $this->banner : $this->thumbnail,
            'country' => $this->when($post->relationLoaded('country'), fn() => new CountryResource($post->country))
        ];
    }
}
