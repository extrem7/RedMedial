<?php

namespace App\Http\Controllers\Admin;

use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\MetaTags\Meta;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public MetaInterface $meta;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->meta = app(MetaInterface::class);

        $this->meta->addStyle('pace', asset_admin('css/pace.css'))
            ->addScript('pace.js', asset_admin('js/pace.js'), [], Meta::PLACEMENT_HEAD)
            ->addStyle('app', mix('admin/css/app.css'))
            ->addScript('main', mix('admin/js/main.js'))
            ->addScript('app.js', mix('admin/js/app.js'));
    }
}
