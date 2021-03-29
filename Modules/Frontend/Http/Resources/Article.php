<?php

namespace Modules\Frontend\Http\Resources;

use App\Models\Rss\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    public function toArray($request): array
    {
        /* @var $model \App\Models\Article|Post */
        $model = $this->resource;
        return [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'thumb' => $this->thumb,
            'link' => $model instanceof Post ? $this->source : $this->link,
            'createdAt' => $this->created_at,
            $this->mergeWhen($model instanceof Post, fn() => [
                'country' => $this->whenLoaded('channel', fn() => [
                    $this->mergeWhen($model->channel->relationLoaded('country'), [
                        'name' => $model->channel->country->name,
                        'link' => $model->channel->country->link
                    ])
                ])
            ])
        ];
    }
}
