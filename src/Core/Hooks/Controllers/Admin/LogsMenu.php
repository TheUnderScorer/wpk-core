<?php

namespace UnderScorer\Core\Hooks\Controllers\Admin;

use UnderScorer\Core\Admin\AdminMenuHandler;
use UnderScorer\Core\Admin\Menu;
use UnderScorer\Core\App;
use UnderScorer\Core\Hooks\Controllers\Controller;
use UnderScorer\Core\Utility\Logger;
use function UnderScorer\Core\view;

/**
 * @author Przemysław Żydek
 */
class LogsMenu extends Controller implements AdminMenuHandler
{

    /**
     * @param App $core
     */
    public function handle( App $core ): void
    {

        if ( $core->getSlug() !== 'wpk' ) {
            return;
        }

        /**
         * @var Menu $coreMenu
         */
        $coreMenu = $core->getContainer()->get( Menu::class );

        $core->getContainer()->add(
            new Menu( 'wpk_logs', [
                'pageTitle' => 'Logs',
                'menuTitle' => 'Logs',
                'callback'  => [ $this, 'menu' ],
            ], $coreMenu ),
            'wpk_logs'
        );

    }

    /**
     * @return void
     */
    public function menu(): void
    {

        $data = [
            'logs' => Logger::getLogs()[ 'logs' ],
        ];

        echo $this->render( 'admin.logs', $data );

    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    protected function setup(): void
    {
        add_action( 'wpk/core/loaded', [ $this, 'handle' ], 11 );
    }

}
