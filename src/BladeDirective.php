<?php

namespace Achillesp\Matryoshka;

class BladeDirective
{
    /**
     * A list of model cache keys.
     *
     * @param array $keys
     */
    protected $keys = [];

    protected $cache;

    public function __construct(RussianCaching $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Setup our caching mechanism.
     *
     * @param mixed $model
     *
     * @return bool
     */
    public function setUp($model)
    {
        // Turn on output buffering
        ob_start();

        $this->keys[] = $key = $model->getCacheKey();

        // return a boolean that indicates if we have cached this model yet
        return $this->cache->has($key);
    }

    public function tearDown()
    {
        // cache it, if necessary, and echo out the html
        return $this->cache->put(
            array_pop($this->keys),
            ob_get_clean()
        );
    }
}
