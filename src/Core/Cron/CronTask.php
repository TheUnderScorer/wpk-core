<?php

namespace UnderScorer\Core\Cron;

use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Hooks\Controllers\Cron\CronController;

/**
 * Handles creating cron task
 *
 * @author Przemysław Żydek
 */
class CronTask implements CronInterface
{

    /**
     * @var string
     */
    protected $hook;

    /**
     * @var array
     */
    protected $controllers = [];

    /**
     * @var AppInterface
     */
    protected $app;

    /**
     * Schedule constructor.
     *
     * @param AppInterface     $app
     * @param string           $hook
     * @param CronController[] $controllers
     */
    public function __construct( AppInterface $app, string $hook = '', array $controllers = [] )
    {
        $this->app = $app;

        if ( ! empty( $hook ) ) {
            $this->hook = $hook;
        }

        if ( ! empty( $controllers ) ) {
            $this->controllers = $controllers;
        }

        $this->setupControllers();
    }

    /**
     * @return void
     */
    private function setupControllers(): void
    {
        foreach ( $this->controllers as $controller ) {
            $instance = new $controller( $this->app, $this );

            $this->app->setupController( $instance );
        }
    }

    /**
     * Clears schedule after disabling plugin
     *
     * @param array $args
     *
     * @return void
     */
    public function removeSchedule( array $args = [] ): void
    {
        wp_clear_scheduled_hook( $this->getHook(), $args );
    }

    /**
     * @return string
     */
    public function getHook(): string
    {
        return $this->hook;
    }

    /**
     * Creates new single event for this cron hook
     *
     * @param int   $timestamp
     * @param array $args
     *
     * @return void
     */
    public function scheduleSingleEvent( int $timestamp, array $args = [] ): void
    {
        wp_schedule_single_event( $timestamp, $this->getHook(), $args );
    }

    /**
     * @return array
     */
    public function getControllers(): array
    {
        return $this->controllers;
    }

}
