<?php

namespace UnderScorer\Core\Hooks\Controllers;

use UnderScorer\Core\BaseController;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\ResponseInterface;

/**
 * @author Przemysław Żydek
 */
abstract class Controller extends BaseController
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
        parent::__construct( $app, $request, $response );

        $this->loadMiddleware();
    }

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

}
