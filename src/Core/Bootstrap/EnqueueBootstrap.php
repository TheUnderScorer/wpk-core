<?php

namespace UnderScorer\Core\Bootstrap;

use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Filesystem\Filesystem;
use UnderScorer\Core\Enqueue;

/**
 * Class EnqueueBootstrap
 * @package UnderScorer\Core\Bootstrap
 */
class EnqueueBootstrap extends BaseBootstrap
{

    /**
     * Performs bootstrap of core functionality.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function bootstrap(): void
    {
        $configDir   = $this->getConfigDir();
        $enqueueFile = $configDir . 'enqueue.php';

        $fileSystem = $this->app->make( Filesystem::class );

        if ( $fileSystem->exists( $enqueueFile ) ) {
            $enqueue = $this->app->make( Enqueue::class );

            require_once $enqueueFile;
        }
    }

}
