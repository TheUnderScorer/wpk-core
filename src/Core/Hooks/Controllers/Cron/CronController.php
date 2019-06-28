<?php

namespace UnderScorer\Core\Hooks\Controllers\Cron;

use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Cron\CronInterface;
use UnderScorer\Core\Hooks\Controllers\Controller;

/**
 * @author Przemysław Żydek
 */
abstract class CronController extends Controller
{

    /**
     * @var CronInterface
     */
    protected $cron;

    /**
     * @param AppInterface  $app
     * @param CronInterface $cron
     */
    public function __construct( AppInterface $app, CronInterface $cron )
    {
        $this->cron = $cron;

        parent::__construct( $app );
    }

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * @return CronInterface
     */
    public function getCron(): CronInterface
    {
        return $this->cron;
    }

    /**
     * @param CronInterface $cron
     *
     * @return CronController
     */
    public function setCron( CronInterface $cron ): CronController
    {
        $this->cron = $cron;

        return $this;
    }

    /**
     * @return void
     */
    protected function setup(): void
    {
        add_action( $this->cron->getHook(), [ $this, 'handle' ] );
    }

}
