<?php

namespace UnderScorer\Core\Tests;

define( 'TESTS_DIR', __DIR__ );

$dir = __DIR__;

require_once $dir . '/../../vendor/autoload.php';

$testsDir = __DIR__ . '/Suite/tests/phpunit';

// disable xdebug backtrace
if ( function_exists( 'xdebug_disable' ) ) {
    xdebug_disable();
}

//define( 'WP_PLUGIN_DIR', $dir . '../../../' );

if ( false !== getenv( 'WP_THEMES_DIR' ) ) {
    define( 'WP_THEMES_DIR', getenv( 'WP_THEMES_DIR' ) );
}

// Start up the WP testing environment.
require $testsDir . '/includes/bootstrap.php';

do_action( 'plugins_loaded' );


