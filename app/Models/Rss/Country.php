<?php

namespace App\Models\Rss;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use Sluggable;

    protected $table = 'rss_countries';

    protected $fillable = [
        'slug', 'name', 'meta_title', 'meta_description'
    ];

    // FUNCTIONS
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'name'
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
}
