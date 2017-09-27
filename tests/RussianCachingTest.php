<?php

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
            new \Illuminate\Cache\ArrayStore
        );

        $cache = new RussianCaching($cache);

        $cache->put($post, 'some html fragment');

        $this->assertTrue($cache->has($post->getCacheKey()));
        $this->assertTrue($cache->has($post));
    }
}
