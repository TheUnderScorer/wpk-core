<?php

namespace UnderScorer\Core\Tests;

use Dotenv\Dotenv;
use UnderScorer\Core\App;

define( 'TESTS_DIR', __DIR__ );

$dir = __DIR__;

require_once $dir . '/../../vendor/autoload.php';

$testsDir = __DIR__ . '/Suite/wordpress-tests-lib';

if ( ! file_exists( $testsDir ) ) {

    $dotenv = Dotenv::create( $dir );
    $dotenv->load();

    $testsDir = getenv( 'WP_TESTS_DIR' );

    if ( ! $testsDir ) {
        echo 'Error! You need to either setup tests suite using docker-compose or provide path to your own tests suite in WP_TESTS_DIR env variable.';

        return;
    }

}

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

/**
 * @var App $app
 */
$app = require $dir . '/../../plugin/index.php';

TestCase::setApp( $app );

do_action( 'plugins_loaded' );


