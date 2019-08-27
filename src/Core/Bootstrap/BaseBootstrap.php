<?php

namespace UnderScorer\Core\Bootstrap;

use UnderScorer\Core\Contracts\AppInterface;

/**
 * Class BaseBootstrap
 * @package UnderScorer\Core\Bootstrap
 *
 * Handles bootstrap processes of certain core functionalities
 */
abstract class BaseBootstrap
{

    /**
     * @var AppInterface
     */
    protected $app;

    /**
     * BaseBootstrap constructor.
     *
     * @param AppInterface $app
     */
    public function __construct( AppInterface $app )
    {
        $this->app = $app;
    }

    /**
     * Performs bootstrap of core functionality.
     *
     * @return void
     */
    abstract public function bootstrap(): void;

    /**
     * @return string
     */
    protected function getConfigPath(): string
    {
        return $this->app->getPath( 'config' );
    }

}
