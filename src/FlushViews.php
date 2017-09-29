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
        Cache::flush();

        return $next($request);
    }
}
