<?php

namespace UnderScorer\Core;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Hooks\Controllers;

/**
 * Class CoreModule
 * @package UnderScorer\Core
 */
class CoreModule extends Module
{

    /**
     * @var array
     */
    protected $controllers = [
        Controllers\Admin\DebugMenu::class,
        Controllers\Admin\CoreMenu::class,
        Controllers\Http\GetCoreVersionHandler::class,
    ];

    /**
     * Performs module bootstrap
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function bootstrap(): void
    {
        $this->setupMenu();
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setupMenu(): void
    {
        $menu  = $this->menu;
        $title = esc_html__( 'Core', 'ez-sked' );

        $enqueue = $this->app->make( Enqueue::class );

        $menu
            ->setSlug( $this->app->getSlug() )
            ->setPageTitle( $title )
            ->setMenuTitle( $title )
            ->setIcon( $enqueue->getAssetsPath( 'img/kraken.png' ) )
            ->setCallback( function () {
                do_action( "wpk.{$this->app->getSlug()}.menu" );
            } );
    }

}
