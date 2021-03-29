<?php

namespace App\Models\Rss;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\EloquentSortable\SortableTrait;

class Language extends Model
{
    use Sluggable;
    use SortableTrait;

    protected $table = 'rss_languages';

    protected $fillable = [
        'slug', 'name', 'code', 'meta_title', 'meta_description'
    ];

    // FUNCTIONS

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
}
