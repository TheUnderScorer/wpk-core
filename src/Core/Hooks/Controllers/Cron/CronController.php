<?php

namespace UnderScorer\Core\Hooks\Controllers\Cron;

use UnderScorer\Core\App;
use UnderScorer\Core\Cron\CronInterface;
use UnderScorer\Core\Hooks\Controllers\Controller;

/**
 * @author Przemysław Żydek
 */
abstract class CronController extends Controller
{

    /**
     * @var App
     */
    protected $app;

    /**
     * @var CronInterface
     */
    protected $cron;

    /**
     * @param App           $app
     * @param CronInterface $cron
     */
    public function __construct( App $app, CronInterface $cron )
    {
        $this->cron = $cron;

        parent::__construct( $app );
    }

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * @return void
     */
    protected function setup(): void
    {
        add_action( $this->cron->getHook(), [ $this, 'handle' ] );
    }

}
