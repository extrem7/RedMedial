<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Sluggable;

    protected $fillable = [
        'slug', 'title', 'body', 'meta_title', 'meta_description'
    ];

    // FUNCTIONS
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'title',
                'onUpdate' => true,
            ]
        ];
    }

}
