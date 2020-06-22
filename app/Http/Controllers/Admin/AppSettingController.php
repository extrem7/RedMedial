<?php

namespace App\Http\Controllers\Admin;

use QCod\AppSettings\SavesSettings;

class AppSettingController extends Controller
{
    use SavesSettings;

    public function __construct()
    {
        $this->seo()->setTitle('Settings');
    }
}
