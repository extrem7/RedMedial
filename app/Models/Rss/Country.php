<?php

namespace App\Models\Rss;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\EloquentSortable\SortableTrait;

class Country extends Model
{
    use Sluggable;
    use SortableTrait;

    protected $table = 'rss_countries';

    protected $fillable = [
        'slug', 'name', 'code', 'meta_title', 'meta_description'
    ];

    // protected $appends = ['link'];

    // FUNCTIONS
    public static function boot(): void
    {
        foreach (['saved', 'deleted'] as $event) {
            static::$event(fn() => \Cacher::countriesForHeader());
        }

        parent::boot();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'name',
                'onUpdate' => true,
            ]
        ];
    }

    // RELATIONS
    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class);
    }

    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(Post::class, Channel::class);
    }

    // ACCESSORS
    public function getLinkAttribute(): string
    {
        return route('frontend.rss.countries.show', $this->slug);
    }

    // MUTATORS
    public function setCodeAttribute($code): void
    {
        $this->attributes['code'] = strtoupper($code);
    }
}
