<?php

namespace UnderScorer\Core\Cron\Cleaners;

use DateTimeInterface;
use UnderScorer\Core\Cron\HasCronStatic;

/**
 * @author Przemysław Żydek
 */
class PostCleaner
{

    use HasCronStatic;

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

}
