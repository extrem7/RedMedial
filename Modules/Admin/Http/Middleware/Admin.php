<?php

namespace Modules\Admin\Http\Middleware;

use Auth;
use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::getUser()->hasRole('admin')) {
            return $next($request);
        }
        abort(404);
    }
}