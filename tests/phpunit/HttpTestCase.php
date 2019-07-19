<?php

namespace UnderScorer\Core\Tests;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\App;
use UnderScorer\Core\Hooks\Controllers\AjaxController;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Tests\Common\Factories\ControllerFactory;
use WPAjaxDieContinueException;

/**
 * Class TestCase
 * @package UnderScorer\Core\Tests
 */
abstract class HttpTestCase extends TestCase
{

    /**
     * @var App Instance of app that is being tested
     */
    protected static $app;

    /**
     * @var ControllerFactory
     */
    protected static $controllerFactory;

    /**
     * @param string  $controller
     * @param Request $request
     *
     * @return array|null
     * @throws BindingResolutionException
     */
    protected function makeAjaxCall( string $controller, ?Request $request = null )
    {
        /**
         * @var AjaxController $instance
         */
        $instance = parent::$app->make( $controller );

        if ( $request ) {
            $instance->setRequest( $request );
        }

        try {
            $instance->handle();
        } catch ( WPAjaxDieContinueException $e ) {

        }

        // Restore buffer
        ob_start();

        return $this->getLastResponse();

    }

    /**
     * @return array|null
     */
    protected function getLastResponse()
    {
        return json_decode( $this->_last_response, true );
    }

}
