<?php

namespace UnderScorer\Core\Providers;

use UnderScorer\Core\Http\Route;
use UnderScorer\Core\Http\Router;

/**
 * Class RouterProvider
 * @package UnderScorer\Core\Providers
 */
class RouterProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->singleton( Router::class );
        $this->app->bind( Route::class );
    }

}
