<?php

namespace UnderScorer\Core\Cron;

use UnderScorer\Core\App;
use UnderScorer\Core\Hooks\Controllers\Cron\CronController;
use UnderScorer\Core\Utility\Date;

/**
 * Handles creating recurrent cron task
 *
 * @author Przemysław Żydek
 */
class RecurrentSchedule extends CronTask
{

    /**
     * @var string Determines how often schedule should run (hourly, twicedaily, daily)
     */
    protected $recurrence = 'hourly';

    /**
     * @var array Args for schedule callbacks
     */
    protected $args = [];

    /**
     * @var string
     */
    protected $pluginFile;

    /**
     * @var Date Date object that contains cron start time
     */
    protected $start;

    /**
     * Schedule constructor.
     *
     * @param App              $app
     * @param string           $hook
     * @param CronController[] $controllers
     * @param string           $recurrence
     * @param Date             $start Date on which first event will be scheduled
     */
    public function __construct( App $app, string $hook, array $controllers, string $recurrence, Date $start = null )
    {

        parent::__construct( $app, $hook, $controllers );

        if ( empty( $start ) ) {
            $start = new Date( '00:00' );
        }

        $this->pluginFile = $app->getFile();
        $this->start      = $start;
        $this->recurrence = $recurrence;

        $this->setupActivationHooks();

    }

    /**
     * Setups schedule activation hooks
     *
     * @return void
     */
    private function setupActivationHooks()
    {
        register_activation_hook( $this->pluginFile, [ $this, 'createSchedule' ] );
        register_deactivation_hook( $this->pluginFile, [ $this, 'clearCronSchedule' ] );
    }

    /**
     * Creates schedule after plugin activation
     *
     * @return void
     */
    public function createSchedule(): void
    {
        wp_schedule_event(
            $this->start->getTimestamp(),
            $this->recurrence,
            $this->getHook(),
            $this->args );
    }

    /**
     * Removes schedule on plugin de-activation
     *
     * @return void
     */
    public function clearCronSchedule(): void
    {
        wp_clear_scheduled_hook( $this->getHook() );
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

}
