<?php


namespace App\Helpers;

use App\Models\Article;
use App\Models\Rss\Post;
use App\Models\User;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class RedMedialPathGenerator implements PathGenerator
{

    /*
    * Get the path for the given media, relative to the root storage path.
    */
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media) . '/';
    }

    /*
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . '/conversions/';
    }

    /*
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    /*
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        $folder = '';
        $collection = $media->collection_name;

        switch ($media->model_type) {
            case Post::class:
                return "rss_posts/" . $media->model_id . "/$collection/";
                break;
            case Article::class:
                return "articles/" . $media->model_id . "/$collection/";
                break;
            case User::class:
                return "users/" . $media->model_id . "/$collection/";
                break;
        }

        return "$folder/" . $media->model_id . "/$collection/" . $media->getKey();
    }
}
