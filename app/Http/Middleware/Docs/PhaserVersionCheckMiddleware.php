<?php

namespace App\Http\Middleware\Docs;

use App\Helpers\DataBaseSelector;
use Closure;
use Illuminate\Http\Request;

/**
 * This middlewre help to know if the route has the correct version (if we have this version inside database)
 */
class PhaserVersionCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $version = $request->version;
        if (DataBaseSelector::has($version))
        {
            DataBaseSelector::setDataBase($version);
        }
        else
        {
            abort(404);
        }

        return $next($request);
    }
}
