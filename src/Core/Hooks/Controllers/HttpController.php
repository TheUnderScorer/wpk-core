<?php

namespace UnderScorer\Core\Hooks\Controllers;

use UnderScorer\Core\App;
use UnderScorer\Core\Hooks\Middleware\Middleware;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\Response;

/**
 * @author Przemysław Żydek
 */
abstract class HttpController extends Controller
{

    /**
     * @var array Array with middleware classes to use
     */
    protected $middleware = [];

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $hook = '';

    /**
     * @var bool Determines whenever this action is public or not (public is accessable by not logged in users)
     */
    protected $public = false;

    /**
     * Controller constructor.
     *
     * @param App      $app
     * @param Request  $request
     * @param Response $response
     */
    public function __construct( App $app, Request $request = null, Response $response = null )
    {

        $this->response = $response;
        $this->request  = $request;

        parent::__construct( $app );

        $this->loadMiddleware();

    }

    /**
     * Perform load of middleware modules
     *
     * @return self
     */
    protected function loadMiddleware(): self
    {

        foreach ( $this->middleware as $key => $middleware ) {
            $this->middleware[ $key ] = new $middleware();
        }

        return $this;

    }

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     *
     * @return HttpController
     */
    public function setResponse( Response $response ): self
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
     * Performs controller setup
     *
     * @return void
     */
    protected function setup(): void
    {

        add_action( "wp_ajax_$this->hook", [ $this, 'handle' ] );

        if ( $this->public ) {
            add_action( "wp_ajax_nopriv_$this->hook", [ $this, 'handle' ] );
        }

    }

    /**
     * Shorthand for registering new action
     *
     * @param string $hook
     * @param string $callback
     * @param int    $priority
     * @param int    $args
     *
     * @return void
     */
    protected function addAction( string $hook, string $callback, int $priority = 10, int $args = 1 )
    {
        add_action( $hook, [ $this, $callback ], $priority, $args );
    }

    /**
     * Shorthand for registering new filter
     *
     * @param string $hook
     * @param string $callback
     * @param int    $priority
     * @param int    $args
     *
     * @return void
     */
    protected function addFilter( string $hook, string $callback, int $priority = 10, int $args = 1 )
    {
        add_filter( $hook, [ $this, $callback ], $priority, $args );
    }

    /**
     * Calls controller middleware
     *
     * @param array|string $middleware If empty all middlewares will be used
     * @param array        $params Optional parameters for middleware
     *
     * @return self
     */
    protected function middleware( $middleware = null, ...$params ): self
    {

        //Call all middlewares
        if ( empty( $middleware ) ) {
            $middleware = array_keys( $this->middleware );
        }

        foreach ( (array) $middleware as $key ) {
            if ( isset( $this->middleware[ $key ] ) ) {
                $this->callMiddleware( $this->middleware[ $key ], $params );
            }
        }

        return $this;

    }

    /**
     * @param Middleware $middleware
     * @param array      $params
     *
     * @return void
     */
    private function callMiddleware( Middleware $middleware, array $params = [] )
    {
        $middleware->handle( $params );
    }

}
