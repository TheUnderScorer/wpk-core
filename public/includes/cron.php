<?php

use UnderScorer\Core\App;
use UnderScorer\Core\Cron\CronTask;
use UnderScorer\Core\Cron\RecurrentSchedule;
use UnderScorer\Core\Utility\Date;

/**
 * @param App $app
 *
 * @return void
 * @throws Exception
 *
 */
function registerCrons( App $app ): void {

    $config = $app->getPath( 'config' );
    $crons  = require $config . 'schedules.php';

    $cron               = $crons[ 'cron' ];
    $recurrentSchedules = $crons[ 'recurrentSchedules' ];

    foreach ( $cron as $hook => $item ) {

        $controllers = $item[ 'controllers' ];

        $app->getContainer()->add(
            new CronTask( $app, $hook, $controllers ), $hook
        );

    }

    foreach ( $recurrentSchedules as $hook => $recurrentSchedule ) {

        $controllers = $recurrentSchedule[ 'controllers' ];
        $recurrence  = $recurrentSchedules[ 'recurrence' ] ?? 'daily';
        $start       = $recurrentSchedule[ 'start' ] ?? new Date( '00:00' );

        $app->getContainer()->add(
            new RecurrentSchedule(
                $app,
                $hook,
                $controllers,
                $recurrence,
                $start ),
            $hook
        );

    }

}


