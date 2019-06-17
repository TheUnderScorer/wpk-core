<?php

namespace UnderScorer\Core;

/**
 * @author Przemysław Żydek
 */
trait WithApp
{

    /**
     * @var App $app
     */
    protected static $app;

    /**
     * @return App
     */
    public static function getApp(): App
    {
        return self::$app;
    }

    /**
     * @param App $app
     */
    public static function setApp( App $app ): void
    {
        self::$app = $app;
    }

}
