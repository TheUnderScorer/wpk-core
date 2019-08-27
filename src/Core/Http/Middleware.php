<?php

namespace UnderScorer\Core\Http;

use UnderScorer\Core\Contracts\AppInterface;

/**
 * @author Przemysław Żydek
 */
abstract class Middleware
{

    /**
     * @var AppInterface
     */
    protected $app;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Middleware constructor.
     *
     * @param AppInterface      $app
     * @param Request           $request
     * @param ResponseInterface $response
     */
    public function __construct( AppInterface $app, ?Request $request = null, ?ResponseInterface $response = null )
    {
        $this->app      = $app;
        $this->request  = $request ? $request : $app->getRequest();
        $this->response = $response ? $response : $app->getResponse();
    }

    /**
     * Calls middleware
     *
     * @return void
     */
    abstract public function handle();

}
