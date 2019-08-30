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
        $typerocketPath      = $this->app->getPath( 'vendor/typerocket/typerocket' );
        $typerocketPathUrl   = $this->app->getUrl( 'vendor/typerocket/typerocket' );
        $typerocketConfigDir = $this->app->getPath( 'config/typerocket' );
        $typerocketPaths     = $this->app->getPath( 'config/typerocket/' ) . 'paths.php';

        define( 'TR_URL', $typerocketPathUrl );
        define( 'TR_APP_NAMESPACE', 'App' );
        define( 'TR_PATH', $typerocketPath );
        define( 'TR_CORE_CONFIG_PATH', $typerocketConfigDir );

        require_once $typerocketPaths;

        new Config( TR_CORE_CONFIG_PATH );
        ( new Launcher() )->initCore();
    }

}
