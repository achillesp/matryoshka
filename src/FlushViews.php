<?php

namespace Achillesp\Matryoshka;

use Cache;

class FlushViews
{
    /**
     * Handle the request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, $next)
    {
        $cache_tags = config('matryoshka.default_cache_tags') ?? [];
        Cache::tags($cache_tags)->flush();

        return $next($request);
    }
}
