<?php

namespace Achillesp\Matryoshka\Test;

use Achillesp\Matryoshka\RussianCaching;

/**
 * @coversRussianCaching
 */
class RussianCachingTest extends TestCase
{
    /** @test */
    public function it_caches_the_given_key()
    {
        $post = $this->makePost();

        $cache = new \Illuminate\Cache\Repository(
            new \Illuminate\Cache\ArrayStore()
        );

        $cache = new RussianCaching($cache);

        $cache->put($post, '<div>some html fragment</div>');

        $this->assertTrue($cache->has($post->getCacheKey()));
        $this->assertTrue($cache->has($post));
    }

    /** @test */
    public function it_does_not_throw_an_exception_when_model_config_is_null()
    {
        $this->app['config']->set('matryoshka.default_cache_tags', null);

        $this->it_caches_the_given_key();
    }
}
