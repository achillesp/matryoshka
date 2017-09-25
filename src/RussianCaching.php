<?php

namespace Achillesp\Babushka;

use Cache;

class RussianCaching
{
    protected static $keys = [];

    public static function setUp($model)
    {
        static::$keys[] = $key = $model->getCacheKey();

        // Turn on output buffering
        ob_start();

        // return a boolean that indicates if we have cached this model yet
        return Cache::has($key);
    }

    public static function tearDown()
    {
        // fetch the cache key
        $key = array_pop(static::$keys);

        // save the output buffer contents to a var, called $html
        $html = ob_get_clean();

        // cache it, if necessary, and echo out the html
        return Cache::rememberForever($key, function () use ($html) {
            return $html;
        });
    }
}
