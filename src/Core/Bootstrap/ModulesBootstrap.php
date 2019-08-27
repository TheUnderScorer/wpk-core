<?php

namespace UnderScorer\Core\Bootstrap;

/**
 * Class ModulesBootstrap
 * @package UnderScorer\Core\Bootstrap
 */
class ModulesBootstrap extends BaseBootstrap
{

    /**
     * Performs bootstrap of core functionality.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        do_action( 'wpk.bootstrap.beforeModules', $this->app );

        $modules = require_once $this->getConfigPath() . '/modules.php';

        foreach ( $modules as $ID => $module ) {
            new $module( $ID, $this->app );
        }
    }

}
