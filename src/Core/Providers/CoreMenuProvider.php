<?php

namespace UnderScorer\Core\Providers;

use UnderScorer\Core\Admin\Menu;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Enqueue;

class CoreMenuProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->singleton( Menu::class, function ( AppInterface $app ) {

            /**
             * @var Enqueue $enqueue
             */
            $enqueue = $app->make( Enqueue::class );

            return new Menu( $app->getSlug(), [
                'pageTitle' => esc_html__( 'Core' ),
                'menuTitle' => esc_html__( 'Core' ),
                'icon'      => $enqueue->getAssetsPath( 'img/kraken.png' ),
                'callback'  => function () {
                    do_action( 'wpk/core/menu' );
                },
            ] );

        } );
    }

}
