<?php

namespace App\Models\Rss;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;

    protected $table = 'rss_categories';

    protected $fillable = [
        'slug', 'name', 'keywords', 'meta_title', 'meta_description'
    ];

    protected $casts = [
        'keywords' => 'array'
    ];

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
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'rss_category_post', 'category_id', 'post_id')->distinct();
    }
}
