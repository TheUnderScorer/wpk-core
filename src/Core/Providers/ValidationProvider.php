<?php

namespace UnderScorer\Core\Providers;

use Rakit\Validation\Validator;

/**
 * Class ValidationProvider
 * @package UnderScorer\Core\Providers
 */
class ValidationProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->bind( Validator::class );
    }

}
