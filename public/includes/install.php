<?php

use Illuminate\Filesystem\Filesystem;
use SuperClosure\Serializer;
use UnderScorer\Core\Admin\Menu;
use UnderScorer\Core\Admin\Notices;
use UnderScorer\Core\App;
use UnderScorer\Core\Cron\Queue\Queue;
use UnderScorer\Core\Enqueue;
use UnderScorer\Core\Storage\Cache;
use UnderScorer\Core\Storage\ServiceContainer;
use UnderScorer\Core\View;

function requireFiles( string $includes ): void
{

    require_once $includes . 'http.php';
    require_once $includes . 'enqueue.php';
    require_once $includes . 'cache.php';
    require_once $includes . 'install.php';
    require_once $includes . 'cron.php';
    require_once $includes . 'acf.php';
    require_once $includes . 'enqueue.php';

}

/**
 * Handles plugin installation process
 *
 * @param App $app
 *
 * @throws Exception
 *
 */
function install( App $app )
{

    $container = $app->getContainer();

    $includes = $app->getPath( 'includes' );
    $config   = $app->getPath( 'config' );

    $fileSystem = new Filesystem();
    $enqueue    = new Enqueue( $app->getSlug(), $app->getUrl( 'public' ) );
    $serializer = new Serializer();
    $view       = new View( $fileSystem, $app->getPath( 'views' ) );
    $notices    = new Notices( $view );

    // Set app instance in helper classes
    Cache::setApp( $app );

    // Include required files
    requireFiles( $includes );

    Queue::setSerializer( $serializer );

    // Load core scripts and styles
    enqueue( $enqueue );

    // Bind core modules into container
    $container->add( $serializer )
              ->add( $enqueue )
              ->add( $notices )
              ->add( $view )
              ->add( $fileSystem );

    // Add core menu
    $container->add( new Menu( 'wpk_core', [
        'pageTitle' => esc_html__( 'Core' ),
        'menuTitle' => esc_html__( 'Core' ),
        'icon'      => $enqueue->getAssetsPath( 'img/kraken.png' ),
        'callback'  => function ()
        {
            do_action( 'wpk/core/menu' );
        },
    ] ) );

    // Register cron tasks
    registerCrons( $app );

    // Load modules
    $modules = require $config . 'modules.php';
    foreach ( $modules as $ID => $module ) {
        new $module( $ID, $app, new ServiceContainer );
    }

    // Load core controllers
    $controllers = require_once $config . 'controllers.php';

    add_action( 'plugins_loaded', function () use ( $app, $controllers )
    {
        $app->loadControllers( $controllers );
    } );

}
