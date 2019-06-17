<?php

namespace UnderScorer\Core\Patterns;

/**
 * This trait should be used by any class that should be instanted only once
 *
 * @author Przemysław Żydek
 */
trait Singleteon
{

    /** @var static */
    protected static $instance;

    /**
     * Single constructor
     */
    protected function __construct()
    {
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {

        if ( empty( static::$instance ) ) {
            static::$instance = new static();
        }

        return static::$instance;

    }

    /**
     * No serializing
     */
    protected function __sleep()
    {
    }

    /**
     * No unserializing
     */
    protected function __wakeup()
    {
    }

}

