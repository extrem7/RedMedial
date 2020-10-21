<?php

namespace App\Models\Rss;

use App\Models\Traits\SearchTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Znck\Eloquent\Traits\BelongsToThrough;

class Post extends Model implements HasMedia
{
    use HasMediaTrait;
    use Sluggable;
    use SearchTrait;
    use HasEagerLimit;
    use BelongsToThrough;

    const UPDATED_AT = null;

    protected $table = 'rss_posts';

    protected $fillable = [
        'channel_id', 'title', 'excerpt', 'body', 'source', 'created_at'
    ];

    protected $search = ['title'];

    // FUNCTIONS
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function uploadImage(string $url): ?Media
    {
        if ($this->imageMedia) $this->deleteMedia($this->imageMedia);

        return $this->addMediaFromUrl($url)->toMediaCollection('image', 's3');
    }

    public function getImage(string $size = ''): string
    {
        if ($this->imageMedia !== null) {
            return $this->imageMedia->getUrl($this->imageMedia->hasGeneratedConversion($size) ? $size : '');
        } else {
            return config('app.url') . '/dist/img/no-image.jpg';
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->useDisk('s3')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->crop('crop-center', 150, 150)
                    ->sharpen(0)
                    ->nonQueued();
                $this->addMediaConversion('thumbnail')
                    ->crop('crop-center', 260, 144)
                    ->sharpen(0)
                    ->nonQueued();
            });
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'title',
            ]
        ];
    }

    // RELATIONS
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function country()
    {
        return $this->belongsToThrough(Country::class, Channel::class, null, '', [
            Country::class => 'country_id',
            Channel::class => 'channel_id'
        ]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'rss_category_post');
    }

    public function imageMedia()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'image');
    }

    // ACCESSORS
    public function getImageAttribute()
    {
        return $this->getImage();
    }

    public function getThumbAttribute()
    {
        return $this->getImage('thumb');
    }

    public function getThumbnailAttribute()
    {
        return $this->getImage('thumbnail');
    }

    public function getLinkAttribute()
    {
        return $this->slug ? route('frontend.rss.posts.show', $this->slug) : $this->source;
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('d M, Y');
    }
}
