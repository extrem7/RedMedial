<?php

namespace App\Models\Rss;

use App\Traits\SearchTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Post extends Model implements HasMedia
{
    use HasMediaTrait;
    use Sluggable;
    use SearchTrait;
    use HasEagerLimit;

    const UPDATED_AT = null;
    protected $table = 'rss_posts';
    protected $fillable = [
        'channel_id', 'title', 'excerpt', 'body', 'link', 'created_at'
    ];
    protected $search = [
        'name', 'excerpt', 'body'
    ];

    // FUNCTIONS
    public function uploadImage(string $url): ?Media
    {
        if ($this->imageMedia) $this->deleteMedia($this->imageMedia);

        return $this->addMediaFromUrl($url)->toMediaCollection('image');
    }

    public function getImage(string $size = ''): string
    {
        if ($this->imageMedia !== null) {
            return $this->imageMedia->getUrl($size);
        } else {
            return asset('/dist/img/no-image.jpg');
        }
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

    // RELATIONS
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function country()
    {
        return $this->hasOneThrough(Country::class, Channel::class);
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

    public function getLinkAttribute()
    {
        return route('frontend.rss.posts.show', $this->slug);
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('d M, Y');
    }
}
