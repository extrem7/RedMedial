<?php

namespace App\Http\Middleware;

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
        if (!config('scalom.debugbar')) {
            Debugbar::disable();
        } else {
            if (!Auth::check()) {
                Debugbar::disable();
            }
        }
        return $next($request);
    }
}
