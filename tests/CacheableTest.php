<?php

namespace Achillesp\Matryoshka\Test;

/**
 * @coversCacheable
 */
class CacheableTest extends TestCase
{
    /** @test */
    public function it_gets_a_unique_cache_key_for_an_eloquent_model()
    {
        // I need an eloquent model instance
        // and that model needs to use the Cacheable trait.
        $model = $this->makePost();

        // and I need to verify the returned value.
        $this->assertSame(
            'Achillesp\Matryoshka\Test\Models\Post/1-'.$model->updated_at->timestamp,
            $model->getCacheKey()
        );
    }
}
