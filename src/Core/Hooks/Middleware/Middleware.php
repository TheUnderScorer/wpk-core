<?php

namespace UnderScorer\Core\Hooks\Middleware;

use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\ResponseInterface;

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
    public function __construct( AppInterface $app, Request $request = null, ResponseInterface $response = null )
    {
        $this->app      = $app;
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * Calls middleware
     *
     * @param mixed $args
     *
     * @return mixed
     */
    abstract public function handle(...$args);

}
