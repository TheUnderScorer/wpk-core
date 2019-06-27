<?php

namespace UnderScorer\Core\Providers;

use Psr\Log\LoggerInterface;
use UnderScorer\Core\Loggers\DebugLogger;

/**
 * Class LoggerProvider
 * @package UnderScorer\Core\Providers
 */
class LoggerProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->singleton( LoggerInterface::class, DebugLogger::class );
    }

}
