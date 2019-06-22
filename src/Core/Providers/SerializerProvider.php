<?php

namespace UnderScorer\Core\Providers;

use SuperClosure\Serializer;

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
        $this->app->singleton( Serializer::class, function () {
            return new Serializer();
        } );
    }

}
