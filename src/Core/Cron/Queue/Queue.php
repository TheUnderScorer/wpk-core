<?php

namespace UnderScorer\Core\Cron\Queue;

use Closure;
use DateTimeInterface;
use SuperClosure\Serializer;
use UnderScorer\Core\Cron\HasCronStatic;

/**
 * Utility for queuing tasks
 *
 * @author Przemysław Żydek
 */
class Queue
{

    use HasCronStatic;

    /**
     * @var Serializer $serializer
     */
    protected static $serializer;

    /**
     * Adds new task into queue
     *
     * @param Closure           $callback
     * @param DateTimeInterface $when
     *
     * @return string Serialized closure
     */
    public static function add( Closure $callback, DateTimeInterface $when ): string
    {

        $serializer = self::$serializer;

        $serializedClosure = $serializer->serialize( $callback );

        self::$cron->scheduleSingleEvent( $when->getTimestamp(), [ $serializedClosure ] );

        return $serializedClosure;

    }

    /**
     * @return Serializer
     */
    public static function getSerializer(): Serializer
    {
        return self::$serializer;
    }

    /**
     * @param Serializer $serializer
     */
    public static function setSerializer( Serializer $serializer ): void
    {
        self::$serializer = $serializer;
    }

}
