<?php

namespace UnderScorer\Core\Providers;

use SuperClosure\Serializer;
use UnderScorer\Core\Cron\Queue\Queue;

/**
 * Class SerializerProvider
 * @package UnderScorer\Core\Providers
 */
class SerializerProvider extends ServiceProvider
{
    /**
     * Registers service
     */
    public function register(): void
    {
        $serializer = new Serializer();

        Queue::setSerializer( $serializer );

        $this->app->singleton( Serializer::class, function () use ( $serializer ) {
            return $serializer;
        } );
    }

}
