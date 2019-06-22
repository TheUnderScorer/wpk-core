<?php

namespace UnderScorer\Core\Providers;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FileSystemProvider
 * @package UnderScorer\Core\Providers
 */
class FileSystemProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->singleton( Filesystem::class, function () {
            return new FileSystem();
        } );
    }

}
