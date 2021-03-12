<?php

namespace Modules\Frontend\Http\Middleware;

use Auth;
use Closure;
use Debugbar;
use Illuminate\Http\Request;

class DebugBarMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Debugbar::disable();

        if (app()->environment('local')
            ||
            (config('redmedial.debugbar') && Auth::check() && Auth::getUser()->hasRole('admin'))) {
            Debugbar::enable();
        }

        return $next($request);
    }
}
