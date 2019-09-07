<?php

namespace UnderScorer\Core\Providers;

use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Contracts\ViewRenderInterface;
use UnderScorer\Core\View;

/**
 * Class ViewProvider
 * @package UnderScorer\Core\Providers
 */
class ViewProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->singleton( ViewRenderInterface::class, function ( AppInterface $app ) {
            return $app->make( View::class, [
                'path' => $app->getPath( 'views' ),
            ] );
        } );
    }

}
