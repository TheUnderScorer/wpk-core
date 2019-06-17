<?php

namespace UnderScorer\Core\Cron;

/**
 * @author Przemysław Żydek
 */
interface CronInterface
{

    /**
     * @return string
     */
    public function getHook(): string;

    /**
     * @param int   $timestamp
     * @param array $args
     *
     * @return mixed
     */
    public function scheduleSingleEvent( int $timestamp, array $args = [] );

    /**
     * @param array $args
     */
    public function removeSchedule( array $args = [] ): void;

    /**
     * Get cron controllers
     *
     * @return array
     */
    public function getControllers(): array;

}
