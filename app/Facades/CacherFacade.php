<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CacherFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cacher';
    }
}
