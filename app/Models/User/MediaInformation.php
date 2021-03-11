<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class MediaInformation extends Model implements HasMedia
{
    use HasMediaTrait;

    public $timestamps = null;

    protected $table = 'users_media_information';

    protected $primaryKey = 'user_id';

    protected $guarded = ['user_id'];

    public $fillable = ['name', 'url', 'facebook', 'phone', 'instagram', 'twitter', 'rss', 'comment'];

    protected $hidden = ['user_id'];

    // FUNCTIONS
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('icon')
                    ->crop('crop-center', 100, 100)
                    ->sharpen(0)
                    ->nonQueued();
            });
        $this->addMediaCollection('statistic')->singleFile();
    }

    // RELATIONS
    public function logoMedia(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'logo');
    }

    public function statisticMedia(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'statistic');
    }

    // ACCESSORS
    public function getLogoAttribute(): ?string
    {
        if ($media = $this->logoMedia) {
            return $media->getUrl();
        }
        return null;
    }

    public function getIconAttribute(): ?string
    {
        if ($media = $this->logoMedia) {
            return $media->getUrl('icon');
        }
        return null;
    }

    public function getStatisticAttribute(): ?string
    {
        if ($media = $this->statisticMedia) {
            return $media->getUrl();
        }
        return null;
    }
}
