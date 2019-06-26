<?php

namespace UnderScorer\Core\Providers;

use Psr\SimpleCache\CacheInterface;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Storage\Cache;

class CacheProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->bind( CacheInterface::class, function ( AppInterface $app ) {
            return new Cache( $app->getSlug(), '+1 hour', $app->getSettings() );
        } );
    }

}