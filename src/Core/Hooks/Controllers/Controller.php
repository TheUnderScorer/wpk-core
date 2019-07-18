<?php

namespace UnderScorer\Core\Hooks\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Contracts\ViewRenderInterface;
use UnderScorer\Core\Hooks\Middleware\Middleware;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\ResponseInterface;
use UnderScorer\Core\Utility\Arr;
use UnderScorer\Core\View;

/**
 * @author Przemysław Żydek
 */
abstract class Controller
{

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Request
     */
    protected $request;

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
     * @param AppInterface           $app
     * @param Request|null           $request
     * @param ResponseInterface|null $response
     */
    public function __construct( AppInterface $app, Request $request = null, ResponseInterface $response = null )
    {
        $this->app      = $app;
        $this->request  = $request;
        $this->response = $response;

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
            $this->middleware[ $key ] = new $middleware( $this->app, $this->request, $this->response );
        }

        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return HttpController
     */
    public function setResponse( ResponseInterface $response ): self
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     *
     * @return HttpController
     */
    public function setRequest( Request $request ): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @param string $path
     * @param array  $data
     *
     * @return string
     * @throws BindingResolutionException
     */
    protected function render( string $path, array $data = [] ): string
    {
        /**
         * @var View $view
         */
        $view = $this->app->make( ViewRenderInterface::class );

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
        $middleware->handle( ...$params );
    }

}
