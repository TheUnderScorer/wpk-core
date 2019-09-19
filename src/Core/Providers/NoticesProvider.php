<?php

namespace UnderScorer\Core\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Admin\Notices;

/**
 * Class NoticesProvider
 * @package UnderScorer\Core\Providers
 */
class NoticesProvider extends ServiceProvider
{

    /**
     * Registers service
     *
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        $this->app->singleton( Notices::class );
        $this->app->make( Notices::class );
    }

}
