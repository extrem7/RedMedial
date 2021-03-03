<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class MediaInformation extends Model
{
    public $timestamps = null;

    protected $table = 'users_media_information';

    protected $primaryKey = 'user_id';

    protected $guarded = ['user_id'];

    protected $fillable = ['name', 'url', 'facebook', 'phone', 'instagram', 'twitter', 'rss', 'comment'];

    protected $hidden = ['user_id'];
}
