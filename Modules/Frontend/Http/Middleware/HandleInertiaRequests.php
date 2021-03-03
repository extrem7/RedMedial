<?php

namespace Modules\Frontend\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'frontend::layouts.inertia';

    public function share(Request $request): array
    {
        $shared = [
            'breadcrumbs' => \Breadcrumbs::generate(),
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
