<?php

namespace Modules\Frontend\Http\Middleware;

use DaveJamesMiller\Breadcrumbs\Exceptions\InvalidBreadcrumbException;
use DaveJamesMiller\Breadcrumbs\Exceptions\UnnamedRouteException;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'frontend::layouts.inertia';

    public function share(Request $request): array
    {
        $breadcrumbs = null;
        if (\Breadcrumbs::exists()) {
            $breadcrumbs = \Breadcrumbs::generate();
        }

        $shared = [
            'meta' => fn() => [
                'title' => explode(\SEOMeta::getTitleSeparator(), \SEOMeta::getTitle())[0]
            ],
            'breadcrumbs' => $breadcrumbs,
            'flash' => []
        ];

        if ($request->session()->has('message')) {
            $shared['flash']['message'] = fn() => $request->session()->get('message');
            $shared['flash']['type'] = fn() => $request->session()->get('type') ?? 'success';
        }
        if ($request->session()->has('error')) {
            $shared['flash']['error'] = fn() => $request->session()->get('error');
        }

        return array_merge(parent::share($request), $shared);
    }
}
