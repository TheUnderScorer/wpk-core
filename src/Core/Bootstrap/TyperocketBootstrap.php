<?php

namespace UnderScorer\Core\Bootstrap;

use TypeRocket\Core\Config;
use TypeRocket\Core\Launcher;

/**
 * Class TyperocketBootstrap
 * @package UnderScorer\Core\Bootstrap
 */
class TyperocketBootstrap extends BaseBootstrap
{

    /**
     * Performs bootstrap of core functionality.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        $rootDir = $this->app->getPath( '' );

        define( 'TR_APP_NAMESPACE', 'App' );
        define( 'TR_PATH', $rootDir . '/vendor/typerocket/typerocket/' );
        define( 'TR_CORE_CONFIG_PATH', TR_PATH . '/config' );

        new Config( TR_CORE_CONFIG_PATH );
        ( new Launcher() )->initCore();
    }

}
