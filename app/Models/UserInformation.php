<?php

namespace App\Models;

use App\Models\Rss\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInformation extends Model
{
    protected $table = 'users_information';

    protected $primaryKey = 'user_id';

    public $timestamps = null;

    protected $fillable = ['country_id', 'bio', 'settings'];

    protected $guarded = ['user_id'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
