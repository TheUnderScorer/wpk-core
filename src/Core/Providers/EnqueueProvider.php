<?php

namespace UnderScorer\Core\Providers;

use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Enqueue;

/**
 * Class EnqueueProvider
 * @package UnderScorer\Core\Providers
 */
class EnqueueProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->singleton( Enqueue::class, function ( AppInterface $app ) {
            return new Enqueue( $app->getSlug(), $app->getUrl( 'public' ) );
        } );
    }

}
