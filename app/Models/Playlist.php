<?php

namespace App\Models;

use Cacher;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;

class Playlist extends Model
{
    use SortableTrait;

    protected $fillable = ['country_id', 'title', 'videos'];

    protected $casts = [
        'videos' => 'array'
    ];

    public static function boot()
    {
        static::saved(fn() => Cacher::playlistsHome());
        static::deleted(fn() => Cacher::playlistsHome());

        parent::boot();
    }
}
