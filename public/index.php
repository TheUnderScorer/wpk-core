<?php

use UnderScorer\Core\AcfSettings;
use UnderScorer\Core\App;
use UnderScorer\Core\Settings;
use UnderScorer\Core\Storage\ServiceContainer;

if ( ! defined( 'CORE_SLUG' ) ) {
    define( 'CORE_SLUG', 'wpk' );
}

if ( ! defined( 'CORE_VERSION' ) ) {
    define( 'CORE_VERSION', '1.0' );
}

$dir  = __DIR__;
$slug = CORE_SLUG;

// Require composer autoloader
require_once $dir . '/../vendor/autoload.php';

// Require plugin installation function
require_once $dir . '/includes/install.php';

try {

    $settings = function_exists( 'get_field' ) ?
        new AcfSettings( $slug ) :
        new Settings( $slug );

    $app = new App(
        $slug,
        __FILE__,
        new ServiceContainer,
        $settings
    );

    install( $app );

    return $app;

} catch ( Exception $e ) {
    echo $e->getMessage();
}


