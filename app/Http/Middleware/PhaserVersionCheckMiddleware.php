<?php

namespace App\Http\Middleware;

use App\Helpers\DataBaseSelector;
use Closure;
use Illuminate\Http\Request;

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
        if (DataBaseSelector::has($version)) {
            DataBaseSelector::setDataBase($version);
        } else {
            abort(404);
        }

        return $next($request);
    }
}
