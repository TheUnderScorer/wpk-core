<?php

namespace UnderScorer\Core\Hooks\Controllers\Admin;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Admin\Menu;
use UnderScorer\Core\Hooks\Controllers\Controller;

/**
 * @author Przemysław Żydek
 */
class DebugMenu extends Controller
{

    /**
     *
     * @return void
     */
    public function handle(): void
    {
        if ( ! wp_doing_ajax() ) {


        }
    }

    /**
     * Performs controller setup
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function setup(): void
    {

        if ( $this->app->getSlug() !== CORE_SLUG ) {
            return;
        }

        /**
         * @var Menu $coreMenu
         */
        $coreMenu = $this->app->make( Menu::class );

        try {
            $coreMenu->addSubmenu( 'wpk_debug', [
                'pageTitle' => 'Debug',
                'menuTitle' => 'Debug',
                'callback'  => [ $this, 'handle' ],
            ] );
        } catch ( Exception $e ) {

        }
    }
}
