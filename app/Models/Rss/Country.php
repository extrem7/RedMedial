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

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'name'
            ]
        ];
    }
}
