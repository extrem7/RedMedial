<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;

class Playlist extends Model
{
    use SortableTrait;

    protected $fillable = ['country_id', 'title', 'videos'];

    protected $casts = [
        'videos' => 'array'
    ];

    public static function boot(): void
    {
        foreach (['saved', 'deleted'] as $event) {
            static::$event(fn() => \Cacher::playlistsHome());
        }

        parent::boot();
    }
}
