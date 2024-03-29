<?php

namespace App\Models\Rss;

use App\Models\Traits\SearchTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\UploadedFile;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Channel extends Model implements HasMedia
{
    use HasMediaTrait;
    use Sluggable;
    use SearchTrait;
    use HasEagerLimit;
    use SortableTrait;

    public const IDLE = 'IDLE';
    public const WORKING = 'WORKING';

    public static $statuses = [
        self::IDLE => 'Idle',
        self::WORKING => 'Working'
    ];

    protected $table = 'rss_channels';

    protected $fillable = [
        'country_id', 'language_id', 'slug', 'name', 'feed', 'source', 'description',
        'use_fulltext', 'use_og', 'is_active', 'status',
        'meta_title', 'meta_description'
    ];

    protected $casts = [
        'country_id' => 'integer',
        'is_active' => 'integer'
    ];

    protected $dates = ['created_at', 'updated_at', 'last_run'];

    protected $search = [
        'name'
    ];

    // FUNCTIONS
    protected static function boot(): void
    {
        static::addGlobalScope('order', fn(Builder $b) => $b->orderBy('order_column',));

        parent::boot();
    }

    public function uploadLogo(UploadedFile $image = null): Media
    {
        if ($this->logoMedia) {
            $this->deleteMedia($this->logoMedia);
        }
        return $this->addMedia($image)->toMediaCollection('logo');
    }

    public function getLogo(string $size = ''): string
    {
        if ($this->logoMedia !== null) {
            return $this->logoMedia->getUrl($size);
        }

        return asset('dist/img/no-image.jpg');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(260)
                    ->height(48)
                    ->sharpen(0)
                    ->nonQueued();
            });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'name',
                'onUpdate' => true
            ]
        ];
    }

    // RELATIONS
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->orderByDesc('id');
    }

    public function logoMedia(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'logo');
    }

    // SCOPES
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // ACCESSORS
    public function getLogoAttribute(): ?string
    {
        return $this->getLogo();
    }

    public function getThumbAttribute(): ?string
    {
        return $this->getLogo('thumb');
    }
}
