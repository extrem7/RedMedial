<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Article extends Model implements HasMedia, Sortable
{
    use HasMediaTrait;
    use Sluggable;
    use SortableTrait;

    public const DRAFT = 'DRAFT';
    public const PUBLISHED = 'PUBLISHED';

    public static $statuses = [
        self::DRAFT => 'Draft',
        self::PUBLISHED => 'Published'
    ];

    protected $fillable = ['title', 'excerpt', 'body', 'order_column'];

    protected $with = ['imageMedia'];

    public function imageMedia()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', '=', 'image');
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
                'source' => $this->slug ? 'slug' : 'title'
            ]
        ];
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
