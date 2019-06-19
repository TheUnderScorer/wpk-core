<?php

namespace UnderScorer\Core\Hooks\Middleware;

use UnderScorer\Core\Contracts\AppInterface;

/**
 * @author Przemysław Żydek
 */
abstract class Middleware
{

    /**
     * @var AppInterface
     */
    protected $app;

    public function __construct( AppInterface $app )
    {
        $this->app = $app;
    }

    /**
     * Calls middleware
     *
     * @return mixed
     */
    abstract public function handle();

}
