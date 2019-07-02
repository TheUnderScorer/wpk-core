<?php

namespace UnderScorer\Core\Cron\Cleaners;

use UnderScorer\Core\Cron\CronTask;
use UnderScorer\Core\Hooks\Controllers\Cleaners\PostRemovalHandler;

/**
 * Class PostCleanerCron
 * @package UnderScorer\Core\Cron\Cleaners
 */
class PostCleanerCron extends CronTask
{

    /**
     * @var string
     */
    protected $hook = 'wpk/cron/cleaners/postCleaner';

    /**
     * @var array
     */
    protected $controllers = [
        PostRemovalHandler::class,
    ];

}
