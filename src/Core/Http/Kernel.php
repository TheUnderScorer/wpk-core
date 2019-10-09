<?php

namespace UnderScorer\Core\Http;

use Throwable;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Exceptions\RequestException;
use UnderScorer\Core\Http\Contracts\KernelInterface;
use UnderScorer\Core\Http\ResponseContents\ErrorResponseContent;

/**
 * Class Kernel
 * @package UnderScorer\Core\Http
 */
class Kernel implements KernelInterface
{

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var array
     */
    protected $args;

    /**
     * @var AppInterface
     */
    protected $app;

    /**
     * Kernel constructor.
     *
     * @param string       $controller
     * @param array        $args
     * @param array        $middlewares
     * @param AppInterface $app
     */
    public function __construct(
        string $controller,
        array $args,
        array $middlewares,
        AppInterface $app
    ) {
        $this->controller  = $controller;
        $this->middlewares = $middlewares;
        $this->args        = $args;
        $this->app         = $app;
    }

    /**
     * Bootstraps kernel
     *
     * @return void
     */
    public function bootstrap(): void
    {
        try {
            $this->handleRequest();
        } catch ( Throwable $e ) {
            $this->handleException( $e );
        }
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    protected function handleRequest(): void
    {
        /**
         * @var Controller $instance
         */
        $instance = $this->app->make( $this->controller, [
            'request'  => $this->app->getRequest(),
            'response' => $this->app->getResponse(),
        ] );

        if ( ! empty( $this->middlewares ) || ! empty( $this->middleware ) ) {
            $this->handleMiddleware();
        }

        $instance->handle( ...$this->args );
    }

    /**
     * Calls middlewares for current route
     *
     * @return void
     */
    protected function handleMiddleware(): void
    {
        foreach ( $this->middlewares as $middleware ) {

            /**
             * @var Middleware $instance
             */
            $instance = new $middleware( $this->app );

            $instance->handle( ...$this->args );
        }
    }

    /**
     * @param Throwable $e
     */
    protected function handleException( Throwable $e ): void
    {
        $errorResponse = new ErrorResponseContent();
        $errorResponse->handleException( $e );

        $response = $this->app->getResponse();
        $response->setContent( $errorResponse );

        if ( $e instanceof RequestException ) {
            $response->setStatusCode( $e->getStatusCode() );
        } else {
            $response->setStatusCode( 500 );
        }

        $response->json();
    }

}
