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
     * RussianCaching constructor.
     *
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
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

        return $this->getCacheWithTags()
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

        return $this->getCacheWithTags()->has($key);
    }

    /**
     * Apply tags to cache if possible/available.
     *
     * @return Cache
     */
    public function getCacheWithTags()
    {
        if (method_exists($this->cache->getStore(), 'tags')) {
            $cache_tags = config('matryoshka.default_cache_tags') ?? [];

            return $this->cache->tags($cache_tags);
        }

        return $this->cache;
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
