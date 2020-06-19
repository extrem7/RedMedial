<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Article extends Model implements HasMedia
{
    use HasMediaTrait;
    use Sluggable;

    public const DRAFT = 'DRAFT';
    public const PUBLISHED = 'PUBLISHED';

    public static $statuses = [
        self::DRAFT => 'Draft',
        self::PUBLISHED => 'Published'
    ];

    protected $fillable = [
        'title', 'excerpt', 'body', 'authors', 'original', 'meta_title', 'meta_description', 'status', 'order_column'
    ];

    public function imageMedia()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'image');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function setSlug(string $slug)
    {
        $this->slug = SlugService::createSlug(self::class, 'slug', $slug);
    }

    public function uploadImage(UploadedFile $image = null)
    {
        $this->addMedia($image)->toMediaCollection('image');
    }

    public function getImage(string $size = ''): string
    {
        if ($this->imageMedia !== null) {
            return $this->imageMedia->getUrl($size);
        } else {
            return asset('img/post-img.svg');
        }
    }

    public function getImageAttribute()
    {
        return $this->getImage();
    }

    public function getLinkAttribute()
    {
        return route('articles.show', $this->slug ?? $this->id);
    }
}
