<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasRoles;
    use HasMediaTrait;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function avatarMedia()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'avatar');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('avatar')->singleFile();
        /*->registerMediaConversions(function (Media $media) {
            $this->addMediaConversion('icon')
                ->crop('crop-center', 100, 100)
                ->sharpen(0)
                ->nonQueued();
        });*/
    }

    public function uploadAvatar(UploadedFile $image = null)
    {
        if ($this->avatarMedia) $this->deleteMedia($this->avatarMedia);

        $this->addMedia($image)->toMediaCollection('avatar');
    }

    public function getAvatar(string $size = ''): string
    {
        if ($this->avatarMedia !== null) {
            return $this->avatarMedia->getUrl($size);
        } else {
            return asset('img/no-avatar.png');
        }
    }

    public function getAvatarAttribute()
    {
        return $this->getAvatar('icon');
    }

    public function getIsSuperAdminAttribute(): bool
    {
        return $this->id === 1 || $this->email === env('INITIAL_USER_EMAIL');
    }
}
