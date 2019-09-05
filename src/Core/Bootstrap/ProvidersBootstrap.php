<?php

namespace UnderScorer\Core\Bootstrap;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Providers\ServiceProvider;

/**
 * Class ProvidersBootstrap
 * @package UnderScorer\Core\Bootstrap
 */
class ProvidersBootstrap extends BaseBootstrap
{

    /**
     * Performs bootstrap of core functionality.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function bootstrap(): void
    {
        $providers = require $this->app->getPath( 'config' ) . 'providers.php';

        foreach ( $providers as $providerClass ) {
            /**
             * @var ServiceProvider $provider
             */
            $provider = $this->app->make( $providerClass );

            $provider->register();
        }
    }
}
