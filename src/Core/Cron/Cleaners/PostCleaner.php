<?php

namespace UnderScorer\Core\Cron\Cleaners;

use DateTimeInterface;
use UnderScorer\Core\Cron\CronInterface;

/**
 * @author Przemysław Żydek
 */
class PostCleaner
{

    /**
     * @var CronInterface Stores cron instance for cleaner
     */
    protected static $cron;

    /**
     * @param int               $postID
     * @param DateTimeInterface $when
     *
     * @return void
     */
    public static function add( int $postID, DateTimeInterface $when ): void
    {
        self::$cron->scheduleSingleEvent( $when->getTimestamp(), [ $postID ] );
    }

    /**
     * @return CronInterface
     */
    public static function getCron(): CronInterface
    {
        return self::$cron;
    }

    /**
     * @param CronInterface $cron
     */
    public static function setCron( CronInterface $cron ): void
    {
        self::$cron = $cron;
    }

}
