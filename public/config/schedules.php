<?php

use UnderScorer\Core\Hooks\Controllers\Cleaners\PostRemovalHandler;
use UnderScorer\Core\Hooks\Controllers\Queue\HandleQueue;

/*
 * Array of crons and recurrent schedules.
 * For crons key of such array should be cron hook that will be used with array of it's controllers
 *
 * For recurrent schedules - key acts as hook, while values are the recurrence, controllers and start date object
 *
 * */

return [
    'cron'               => [
        'wpk/cron/queue/job'            => [
            'controllers' => [
                HandleQueue::class,
            ],
        ],
        'wpk/cron/cleaners/postCleaner' => [
            'controllers' => [
                PostRemovalHandler::class,
            ],
        ],
    ],
    'recurrentSchedules' => [
    ],
];
