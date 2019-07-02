<?php

namespace UnderScorer\Core\Cron;

trait HasCronStatic
{
    /**
     * @var CronInterface Stores cron instance for cleaner
     */
    protected static $cron;

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
