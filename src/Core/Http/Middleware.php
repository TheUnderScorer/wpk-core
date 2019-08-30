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
     * @return AppInterface
     */
    public function getApp(): AppInterface
    {
        return $this->app;
    }

    /**
     * @param AppInterface $app
     *
     * @return static
     */
    public function setApp( AppInterface $app ): self
    {
        $this->app = $app;

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
     * @return static
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
     * @return static
     */
    public function setRequest( Request $request ): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Calls middleware
     *
     * @return void
     */
    abstract public function handle();

}
