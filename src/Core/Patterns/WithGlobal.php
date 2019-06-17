<?php

namespace UnderScorer\Core\Patterns;

/**
 * @author Przemysław Żydek
 */
trait WithGlobal
{

    /**
     * @var self
     */
    protected static $globalInstance;

    /**
     * @return self
     */
    public static function global(): self
    {
        return self::$globalInstance;
    }

    /**
     * @param self $globalInstance
     *
     * @return void
     */
    public static function setGlobalInstance( $globalInstance ): void
    {
        self::$globalInstance = $globalInstance;
    }
}
