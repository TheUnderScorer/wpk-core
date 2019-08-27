<?php

namespace UnderScorer\Core;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Contracts\ViewRenderInterface;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\ResponseInterface;

/**
 * @author Przemysław Żydek
 */
abstract class BaseController
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
     * @var AppInterface Stores main app instance
     */
    protected $app;

    /**
     * Controller constructor.
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

        $this->setup();
    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    abstract protected function setup(): void;

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
    public function setResponse( ResponseInterface $response )
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
    public function setRequest( Request $request )
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
}
