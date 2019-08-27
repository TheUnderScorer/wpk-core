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

    protected $configDir = '';

    /**
     * BaseBootstrap constructor.
     *
     * @param AppInterface $app
     * @param string       $configDir
     */
    public function __construct( AppInterface $app, string $configDir = '' )
    {
        $this->app       = $app;
        $this->configDir = $configDir ? $configDir : $this->app->getPath( 'config' );
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
    public function getConfigDir(): string
    {
        return $this->configDir;
    }

}
