<?php

namespace App\Models\Rss;

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

    protected $appends = ['link'];

    // FUNCTIONS
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
        return $this->belongsToMany(Post::class, 'rss_category_post')->distinct();
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
