<?php

namespace UnderScorer\Core\Bootstrap;

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
     */
    public function bootstrap(): void
    {
        $providers = require $this->app->getPath( 'config' ) . 'providers.php';

        foreach ( $providers as $providerClass ) {
            /**
             * @var ServiceProvider $provider
             */
            $provider = new $providerClass( $this->app );

            $provider->register();
        }
    }
}
