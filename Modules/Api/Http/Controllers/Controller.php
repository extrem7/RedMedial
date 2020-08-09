<?php

namespace Modules\Api\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers, ValidatesRequests;
}
