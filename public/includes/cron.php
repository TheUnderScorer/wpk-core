<?php

use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Cron\CronTask;
use UnderScorer\Core\Cron\RecurrentSchedule;
use UnderScorer\Core\Utility\Date;


/**
 * @param AppInterface $app
 *
 * @return void
 * @throws Exception
 *
 */
function registerCrons( AppInterface $app ): void
{

    $config = $app->getPath( 'config' );
    $crons  = require $config . 'schedules.php';

    $cron               = $crons[ 'cron' ];
    $recurrentSchedules = $crons[ 'recurrentSchedules' ];

    foreach ( $cron as $hook => $item ) {

        $controllers = $item[ 'controllers' ];

        $app->singleton($hook, new CronTask( $app, $hook, $controllers ));

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


