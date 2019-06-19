<?php

namespace UnderScorer\Core\Hooks\Controllers;

use UnderScorer\Core\App;
use UnderScorer\Core\Hooks\Middleware\HttpMiddleware;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\Response;

/**
 * @author Przemysław Żydek
 */
abstract class HttpController extends Controller
{

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
     * Perform load of middleware modules
     *
     * @return static
     */
    protected function loadMiddleware()
    {

        foreach ( $this->middleware as $key => $middleware ) {
            $this->middleware[ $key ] = new $middleware( $this->app );

            if ( $middleware instanceof HttpMiddleware ) {
                $middleware->setRequest( $this->request );
                $middleware->setResponse( $this->response );
            }
        }

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

}
