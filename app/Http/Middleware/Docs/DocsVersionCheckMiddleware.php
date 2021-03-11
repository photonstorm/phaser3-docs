<?php

namespace App\Http\Middleware\Docs;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class DocsVersionCheckMiddleware
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
        $docs_version = Config::get('app.docs_version');
        $cache_docs_version = Cache::get('docs.version');

        // If not exist version in cache: save it
        if(!$cache_docs_version) {
            Cache::rememberForever('docs.version', function() use ($docs_version) {
                return $docs_version;
            });
            $cache_docs_version = $docs_version;
        }
        // Check if the docs has the same version cache
        if ($cache_docs_version !== $docs_version) {
            Cache::flush();
            Cache::rememberForever('docs.version', function() use ($docs_version) {
                return $docs_version;
            });
        }

        return $next($request);
    }
}
