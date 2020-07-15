<?php

namespace Modules\Frontend\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Pagination
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
        if ($page = $request->route()->parameter('page')) {
            $request->attributes->add(['page' => $page]);
        }

        return $next($request);
    }
}
