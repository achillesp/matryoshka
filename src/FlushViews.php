<?php

namespace Achillesp\Babushka\Middleware;

use Cache;

class FlushViews
{
    public function handle($request, $next)
    {
        if ('local' === app()->environment()) {
            // Clear the view-specific cache.
            Cache::flush();
        }

        return $next($request);
    }
}
