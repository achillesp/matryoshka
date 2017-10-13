<?php

namespace Achillesp\Matryoshka;

use Illuminate\Contracts\Cache\Repository as Cache;

class RussianCaching
{
    /**
     * The cache repository.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * The cache tags used.
     *
     * @var array|\Illuminate\Config\Repository|mixed
     */
    protected $cache_tags;

    /**
     * RussianCaching constructor.
     *
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
        $this->cache_tags = config('matryoshka.default_cache_tags') ?? [];
    }

    /**
     * Put to the cache.
     *
     * @param mixed  $key
     * @param string $fragment
     *
     * @return mixed
     */
    public function put($key, $fragment)
    {
        $key = $this->normalizeCacheKey($key);

        return $this->cache
            ->tags($this->cache_tags)
            ->rememberForever($key, function () use ($fragment) {
                return $fragment;
            });
    }

    /**
     * Check if the given key exists in the cache.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function has($key)
    {
        $key = $this->normalizeCacheKey($key);

        return $this->cache
            ->tags($this->cache_tags)
            ->has($key);
    }

    /**
     * Normalize the cache key.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    protected function normalizeCacheKey($key)
    {
        if (is_object($key) && method_exists($key, 'getCacheKey')) {
            return $key->getCacheKey();
        }

        return $key;
    }
}
