<?php

namespace UnderScorer\Core\Providers;

use UnderScorer\Core\Admin\Notices;

/**
 * Class NoticesProvider
 * @package UnderScorer\Core\Providers
 */
class NoticesProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->singleton( Notices::class );
    }

}
