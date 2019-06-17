<?php

namespace UnderScorer\Core\Hooks\Controllers\Admin;

use Exception;
use UnderScorer\Core\Admin\AdminMenuHandler;
use UnderScorer\Core\Admin\Menu;
use UnderScorer\Core\App;
use UnderScorer\Core\Hooks\Controllers\Controller;
use UnderScorer\Core\Models\WP\Observers\ModelObserver;
use UnderScorer\Core\Models\WP\Post;
use const WPK_CORE_SLUG;

/**
 * @author Przemysław Żydek
 */
class DebugMenu extends Controller implements AdminMenuHandler
{

    /**
     * @param App $core
     *
     * @return void
     */
    public function handle( App $core ): void
    {

        if ( $core->getSlug() !== WPK_CORE_SLUG ) {
            return;
        }

        /**
         * @var Menu $coreMenu
         */
        $coreMenu = $core->getContainer()->get( Menu::class );

        try {
            $coreMenu->addSubmenu( 'wpk_debug', [
                'pageTitle' => 'Debug',
                'menuTitle' => 'Debug',
                'callback'  => [ $this, 'menu' ],
            ] );
        } catch ( Exception $e ) {

        }

    }

    /**
     * Debug menu callback
     *
     * @return void
     */
    public function menu(): void
    {

        if ( ! wp_doing_ajax() ) {
            Post::observe( ModelObserver::class );

            $post     = Post::find( 34 );
            $postCopy = Post::find( 34 );

            echo '<pre>';
            var_dump( $post->post_title );
            echo '</pre>';

        }

    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    protected function setup(): void
    {

        if ( $this->app->getSlug() !== CORE_SLUG ) {
            return;
        }

        /**
         * @var Menu $coreMenu
         */
        $coreMenu = $this->app->getContainer()->get( Menu::class );

        try {
            $coreMenu->addSubmenu( 'wpk_debug', [
                'pageTitle' => 'Debug',
                'menuTitle' => 'Debug',
                'callback'  => [ $this, 'menu' ],
            ] );
        } catch ( Exception $e ) {

        }
    }
}
