<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteChannel extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $table = 'user_favorite_channels';
    protected $fillable = ['user_id', 'channel_id'];
}
