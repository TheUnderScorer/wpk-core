<?php

namespace UnderScorer\Core\Bootstrap;

use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Filesystem\Filesystem;
use UnderScorer\Core\Http\Router;

/**
 * Class RoutesBootstrap
 * @package UnderScorer\Core\Bootstrap
 */
class RoutesBootstrap extends BaseBootstrap
{

    /**
     * Performs bootstrap of core functionality.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function bootstrap(): void
    {
        $fileSystem = $this->app->make( Filesystem::class );

        $router     = $this->app->make( Router::class );
        $routesFile = $this->getConfigDir() . 'routes.php';

        if ( ! $fileSystem->exists( $routesFile ) ) {
            return;
        }

        require $routesFile;
    }
}
