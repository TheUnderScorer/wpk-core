<?php

namespace UnderScorer\Core\Hooks\Middleware;

use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\ResponseInterface;

/**
 * Class HttpMiddleware
 * @package UnderScorer\Core\Hooks\Middleware
 */
abstract class HttpMiddleware extends Middleware
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
     * HttpMiddleware constructor.
     *
     * @param AppInterface      $app
     * @param Request           $request
     * @param ResponseInterface $response
     */
    public function __construct( AppInterface $app, Request $request = null, ResponseInterface $response = null )
    {
        parent::__construct( $app );

        $this->request  = $request;
        $this->response = $response;
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
     * @return HttpMiddleware
     */
    public function setResponse( ResponseInterface $response ): HttpMiddleware
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
     * @return HttpMiddleware
     */
    public function setRequest( Request $request ): HttpMiddleware
    {
        $this->request = $request;

        return $this;
    }

}
