<?php

namespace App\Models\Rss;

use App\Models\Traits\SearchTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Znck\Eloquent\Traits\BelongsToThrough;

class Post extends Model implements HasMedia, Feedable
{
    use HasMediaTrait;
    use Sluggable;
    use SearchTrait;
    use HasEagerLimit;
    use BelongsToThrough;

    public const UPDATED_AT = null;

    protected $table = 'rss_posts';

    protected $fillable = [
        'channel_id', 'title', 'excerpt', 'body', 'source', 'created_at'
    ];

    protected $search = ['title'];

    // FUNCTIONS
    protected static function boot(): void
    {
        static::addGlobalScope('order', fn(Builder $b) => $b->orderBy('created_at', 'desc'));

        parent::boot();
    }

    public function uploadImage(string $url): ?Media
    {
        if ($this->imageMedia) {
            $this->deleteMedia($this->imageMedia);
        }

        return $this->addMediaFromUrl($url)->toMediaCollection('image', 's3');
    }

    public function getImage(string $size = ''): string
    {
        if ($this->imageMedia !== null) {
            return $this->imageMedia->getUrl($this->imageMedia->hasGeneratedConversion($size) ? $size : '');
        }

        return config('app.url') . '/dist/img/no-image.jpg';
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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'title',
            ]
        ];
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => route('frontend.rss.posts.show', $this->id),
            'title' => $this->title,
            'summary' => $this->excerpt,
            'updated' => $this->created_at,
            'link' => $this->link,
            'author' => $this->channel->name,
            'category' => $this->categories->pluck('name')->toArray()
        ]);
    }

    // RELATIONS
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function country(): \Znck\Eloquent\Relations\BelongsToThrough
    {
        return $this->belongsToThrough(Country::class, Channel::class, null, '', [
            Country::class => 'country_id',
            Channel::class => 'channel_id'
        ]);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'rss_category_post');
    }

    public function imageMedia(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'image');
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

    public function getLinkAttribute(): string
    {
        return $this->slug ? route('frontend.rss.posts.show', $this->slug) : $this->source;
    }

    public function getDateAttribute(): string
    {
        return $this->created_at->format('d M, Y');
    }
}
