<?php

namespace UnderScorer\Core\Hooks\Controllers;

use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Hooks\Middleware\Middleware;
use UnderScorer\Core\Utility\Arr;
use UnderScorer\Core\View;

/**
 * @author Przemysław Żydek
 */
abstract class Controller
{
    /**
     * @var array Array with middleware classes to use
     */
    protected $middleware = [];

    /**
     * @var AppInterface Stores main app instance
     */
    protected $app;

    /**
     * Controller constructor.
     *
     * @param AppInterface $app
     */
    public function __construct( AppInterface $app )
    {
        $this->app = $app;

        $this->setup();
        $this->loadMiddleware();
    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    abstract protected function setup(): void;

    /**
     * Perform load of middleware modules
     *
     * @return static
     */
    protected function loadMiddleware()
    {

        foreach ( $this->middleware as $key => $middleware ) {
            $this->middleware[ $key ] = new $middleware( $this->app );
        }

        return $this;

    }

    /**
     * @param string $path
     * @param array  $data
     *
     * @return string
     */
    protected function render( string $path, array $data = [] ): string
    {

        /**
         * @var View $view
         */
        $view = $this->app->getContainer()->get( View::class );

        return $view->render( $path, $data );

    }

    /**
     * Calls controller middleware
     *
     * @param array|string $middleware If empty all middlewares will be used
     * @param array        $params Optional parameters for middleware
     *
     * @return static
     */
    protected function middleware( $middleware = null, ...$params )
    {

        if ( empty( $middleware ) ) {
            $middleware = array_keys( $this->middleware );
        }

        foreach ( Arr::make( $middleware ) as $key ) {
            if ( isset( $this->middleware[ $key ] ) ) {
                $this->callMiddleware( $this->middleware[ $key ], $params );
            }
        }

        return $this;

    }

    /**
     * Calls middleware with provided params
     *
     * @param Middleware $middleware
     * @param array      $params
     *
     * @return void
     */
    private function callMiddleware( Middleware $middleware, array $params = [] ): void
    {
        call_user_func_array( [ $middleware, 'handle' ], $params );
    }

}
