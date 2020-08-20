<?php

namespace App\Models;

use App\Models\Rss\Country;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $primaryKey = 'user_id';

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'users_information';

    protected $fillable = ['country_id', 'bio', 'settings'];

    protected $guarded = ['user_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
