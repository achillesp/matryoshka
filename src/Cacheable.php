<?php

namespace Achillesp\Matryoshka;

trait Cacheable
{
    /**
     * Calculate a unique cache key for the model instance.
     *
     * @return string
     */
    public function getCacheKey()
    {
        return sprintf('%s/%s-%s',
            get_class($this),
            $this->getKey(),
            $this->updated_at->timestamp
        );
    }
}
