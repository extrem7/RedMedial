<?php

namespace App\Models\Rss;

use Cacher;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
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
    public static function boot()
    {
        static::saved(fn() => Cacher::countriesForHeader());
        static::deleted(fn() => Cacher::countriesForHeader());

        parent::boot();
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'name',
                'onUpdate' => true,
            ]
        ];
    }

    // RELATIONS
    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, Channel::class);
    }

    // ACCESSORS
    public function getLinkAttribute(): string
    {
        return route('frontend.rss.countries.show', $this->slug);
    }

    // MUTATORS
    public function setCodeAttribute($code)
    {
        $this->attributes['code'] = strtoupper($code);
    }
}
