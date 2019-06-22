<?php

namespace UnderScorer\Core\Providers;

use UnderScorer\Core\Contracts\AppInterface;

/**
 * Class ServiceProvider
 * @package UnderScorer\Core\Providers
 */
abstract class ServiceProvider
{

    /**
     * @var AppInterface $app
     */
    protected $app;

    /**
     * ServiceProvider constructor.
     *
     * @param AppInterface $app
     */
    public function __construct( AppInterface $app )
    {
        $this->app = $app;
    }

    /**
     * Registers service
     */
    abstract public function register(): void;

}
