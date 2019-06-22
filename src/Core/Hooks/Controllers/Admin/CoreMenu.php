<?php

namespace UnderScorer\Core\Hooks\Controllers\Admin;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Hooks\Controllers\Controller;

/**
 * @author Przemysław Żydek
 */
class CoreMenu extends Controller
{

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function handle(): void
    {

        $data = [
            'version'    => $this->app->getSetting( 'version' ),
            'phpVersion' => PHP_VERSION,
        ];

        echo $this->render( 'admin.core-info', $data );

    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    protected function setup(): void
    {
        add_action( 'wpk/core/menu', [ $this, 'handle' ] );
    }

}
