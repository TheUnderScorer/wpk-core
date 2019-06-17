<?php

namespace UnderScorer\Core\Tests\Core\Cron\Queue;

use Exception;
use UnderScorer\Core\Cron\CronInterface;
use UnderScorer\Core\Cron\Queue\Queue;
use UnderScorer\Core\Tests\TestCase;
use UnderScorer\Core\Utility\Date;

/**
 * Class QueueTest
 * @package UnderScorer\Core\Tests\Core\Cron\Queue
 */
final class QueueTest extends TestCase
{

    /**
     * @covers \UnderScorer\Core\Cron\Queue\Queue
     */
    public function testIsTaskBeingExecuted()
    {

        $closure = function () {
            throw new Exception( 'Task was executed!' );
        };

        $serializedClosure = Queue::add( $closure, Date::now()->addSeconds( 5 ) );

        $this->setExpectedException(
            Exception::class,
            'Task was executed!'
        );

        /**
         * @var CronInterface $cron
         */
        $cron = self::$app->getContainer()->get( 'wpk/cron/queue/job' );

        do_action(
            $cron->getHook(), $serializedClosure
        );

    }

}
