<?php


namespace App\Helpers;

use App\Models\Article;
use App\Models\Rss\Channel;
use App\Models\Rss\Post;
use App\Models\User;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class RedMedialPathGenerator implements PathGenerator
{

    public function getPath(Media $media): string
    {
        return $this->getBasePath($media) . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    protected function getBasePath(Media $media): string
    {
        $folder = '';
        $collection = $media->collection_name;

        switch ($media->model_type) {
            case Post::class:
                return "rss/posts/" . $media->model_id . "/$collection";
                break;
            case Article::class:
                return "articles/" . $media->model_id . "/$collection";
                break;
            case Channel::class:
                return "rss/channels/" . $media->model_id . "/$collection";
                break;
            case User::class:
                return "users/" . $media->model_id . "/$collection";
                break;
        }

        return "$folder/" . $media->model_id . "/$collection/" . $media->getKey();
    }
}
