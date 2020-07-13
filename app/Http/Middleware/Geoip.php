<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Torann\GeoIP\Location;

class Geoip
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
        $location = config('app.env') === 'local' ? geoip(env('LOCAL_GEOIP')) : geoip();
        if ($location instanceof Location) {
            $code = $location->iso_code;
            $request->attributes->add(['country' => $code]);
        }

        return $next($request);
    }
}
