<?php

namespace UnderScorer\Core\Hooks\Controllers\Admin;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Admin\Menu;
use UnderScorer\Core\Hooks\Controllers\Controller;
use UnderScorer\Core\Utility\Logger;

/**
 * @author Przemysław Żydek
 */
class LogsMenu extends Controller
{

    /**
     * @return void
     * @throws BindingResolutionException
     *
     */
    public function handle(): void
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
            $coreMenu->addSubmenu( 'wpk_logs', [
                'pageTitle' => 'Logs',
                'menuTitle' => 'Logs',
                'callback'  => [ $this, 'handle' ],
            ] );
        } catch ( Exception $e ) {

        }
    }
}
