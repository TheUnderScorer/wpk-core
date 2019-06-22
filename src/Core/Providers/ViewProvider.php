<?php

namespace UnderScorer\Core\Providers;

use Symfony\Component\Filesystem\Filesystem;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Contracts\ViewRenderInterface;
use UnderScorer\Core\View;

class ViewProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->singleton( ViewRenderInterface::class, function ( AppInterface $app ) {
            return new View(
                $this->app->make( Filesystem::class ),
                $app->getPath( 'views' )
            );
        } );
    }

}
