<?php

namespace UnderScorer\Core\Bootstrap;

use Exception;
use Symfony\Component\Filesystem\Filesystem;
use UnderScorer\Core\Utility\Date;

/**
 * Class CronsBootstrap
 * @package UnderScorer\Core\Bootstrap
 */
class CronsBootstrap extends BaseBootstrap
{

    /**
     * Performs bootstrap of core functionality.
     *
     * @return void
     * @throws Exception
     */
    public function bootstrap(): void
    {
        $app        = $this->app;
        $fileSystem = $app->make( Filesystem::class );

        $config = $app->getPath( 'config' );
        $file   = $config . 'schedules.php';

        if ( ! $fileSystem->exists( $file ) ) {
            return;
        }

        $crons = require $file;

        $cron               = $crons[ 'cron' ];
        $recurrentSchedules = $crons[ 'recurrentSchedules' ];

        $this->handleCrons( $cron )->handleRecurrentSchedules( $recurrentSchedules );
    }

    /**
     * @param array $schedules
     *
     * @return CronsBootstrap
     * @throws Exception
     */
    protected function handleRecurrentSchedules( array $schedules ): self
    {
        foreach ( $schedules as $class ) {
            $recurrence = $schedules[ 'recurrence' ] ?? 'daily';
            $start      = $schedules[ 'start' ] ?? new Date( '00:00' );

            $instance = new $class( $this->app, $recurrence, $start );

            $this->app->singleton( $class, function () use ( $instance ) {
                return $instance;
            } );
        }

        return $this;
    }

    /**
     * @param array $crons
     *
     * @return CronsBootstrap
     */
    protected function handleCrons( array $crons ): self
    {
        foreach ( $crons as $class ) {
            $instance = new $class( $this->app );

            $this->app->singleton( $class, function () use ( $instance ) {
                return $instance;
            } );
        }

        return $this;
    }
}
