<?php

namespace UnderScorer\Core\Cron\Queue;

use UnderScorer\Core\Cron\CronTask;
use UnderScorer\Core\Hooks\Controllers\Queue\HandleQueue;

/**
 * Class QueueCron
 * @package UnderScorer\Core\Cron\Queue
 */
class QueueCron extends CronTask
{

    /**
     * @var string
     */
    protected $hook = 'wpk/cron/queue/job';

    /**
     * @var array
     */
    protected $controllers = [
        HandleQueue::class,
    ];

}
