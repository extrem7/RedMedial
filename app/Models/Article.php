<?php

namespace App\Models;

use App\Traits\SearchTrait;
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
    use SearchTrait;

    public const DRAFT = 'DRAFT';
    public const PUBLISHED = 'PUBLISHED';

    public static $statuses = [
        self::DRAFT => 'Draft',
        self::PUBLISHED => 'Published'
    ];

    protected $fillable = [
        'title', 'excerpt', 'body', 'authors', 'original', 'meta_title', 'meta_description', 'status', 'order_column'
    ];

    protected $search = [
        'title', 'excerpt'
    ];

    public function imageMedia()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'image');
    }

    public function scopePublished($query)
    {
        return $query->whereStatus(self::PUBLISHED);
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->crop('crop-center', 150, 150)
                    ->sharpen(0)
                    ->nonQueued();
            });
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
        if ($this->imageMedia) $this->deleteMedia($this->imageMedia);
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

    public function getThumbAttribute()
    {
        return $this->getImage('thumb');
    }

    public function getLinkAttribute()
    {
        return route('frontend.articles.show', $this->slug ?? $this->id);
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('d M, Y');
    }
}
