<?php

namespace App\Models;

use App\Models\Traits\SearchTrait;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
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

    // FUNCTIONS
    public static function boot(): void
    {
        static::saving(function (self $article) {
            if (!$article->excerpt) {
                $article->excerpt = mb_substr($article->body, 0, 510);
            }
        });

        parent::boot();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->crop('crop-center', 150, 150)
                    ->sharpen(0)
                    ->nonQueued();
                $this->addMediaConversion('thumbnail')
                    ->crop('crop-center', 260, 144)
                    ->sharpen(0)
                    ->nonQueued();
                $this->addMediaConversion('banner')
                    ->crop('crop-center', 650, 556)
                    ->sharpen(0)
                    ->nonQueued();
            });
    }

    public function setSlug(string $slug): void
    {
        $this->slug = SlugService::createSlug(self::class, 'slug', $slug);
    }

    public function uploadImage(UploadedFile $image = null): void
    {
        if ($this->imageMedia) {
            $this->deleteMedia($this->imageMedia);
        }
        $this->addMedia($image)->toMediaCollection('image');
    }

    public function getImage(string $size = ''): string
    {
        if ($this->imageMedia !== null) {
            return url($this->imageMedia->getUrl($size));
        }

        return asset('dist/img/no-image.jpg');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'title',
                'onUpdate' => true,
            ]
        ];
    }

    // RELATIONS
    public function imageMedia(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'image');
    }

    // SCOPES
    public function scopePublished($query): Builder
    {
        return $query->whereStatus(self::PUBLISHED);
    }

    //SETTERS
    public function setExcerptAttribute(string $excerpt): void
    {
        $this->attributes['excerpt'] = strip_tags($excerpt);
    }

    // ACCESSORS
    public function getImageAttribute(): string
    {
        return $this->getImage();
    }

    public function getThumbAttribute(): string
    {
        return $this->getImage('thumb');
    }

    public function getThumbnailAttribute(): string
    {
        return $this->getImage('thumbnail');
    }

    public function getBannerAttribute(): string
    {
        return $this->getImage('banner');
    }

    public function getLinkAttribute(): string
    {
        return route('frontend.articles.show', $this->slug ?? $this->id);
    }

    public function getDateAttribute(): string
    {
        return $this->created_at->format('d M, Y');
    }
}
