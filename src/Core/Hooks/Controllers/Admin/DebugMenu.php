<?php

namespace UnderScorer\Core\Hooks\Controllers\Admin;

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
     */
    protected function setup(): void
    {
        if ( $this->app->getSlug() !== CORE_SLUG ) {
            return;
        }

        new Menu( 'wpk_debug', [
            'pageTitle'  => 'Debug',
            'menuTitle'  => 'Debug',
            'callback'   => [ $this, 'handle' ],
            'parentSlug' => $this->app->getSlug(),
        ] );
    }
}
