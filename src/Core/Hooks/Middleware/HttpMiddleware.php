<?php

namespace UnderScorer\Core\Hooks\Middleware;

use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\Response;

/**
 * Class HttpMiddleware
 * @package UnderScorer\Core\Hooks\Middleware
 */
abstract class HttpMiddleware extends Middleware
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
     * HttpMiddleware constructor.
     *
     * @param AppInterface $app
     * @param Request      $request
     * @param Response     $response
     */
    public function __construct( AppInterface $app, Request $request = null, Response $response = null )
    {
        parent::__construct( $app );

        $this->request  = $request;
        $this->response = $response;
    }

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
     * @return HttpMiddleware
     */
    public function setResponse( Response $response ): HttpMiddleware
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
