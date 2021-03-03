<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteChannel extends Model
{
    protected $table = 'user_favorite_channels';

    public $timestamps = null;

    protected $fillable = ['user_id', 'channel_id'];
}
