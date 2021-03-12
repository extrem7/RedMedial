<?php

namespace Modules\Admin\Http\Middleware;

use Auth;
use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::getUser()->hasRole(['admin', 'editor'])) {
            return $next($request);
        }
        abort(503);
    }
}
