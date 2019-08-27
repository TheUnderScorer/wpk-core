<?php

namespace UnderScorer\Core\Http;

use Throwable;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Hooks\Middleware\Middleware;
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
            $errorResponse = new ErrorResponseContent();
            $errorResponse->handleException( $e );

            $this->app
                ->getResponse()
                ->setContent( $errorResponse )
                ->json();
        }
    }

    protected function handleRequest(): void
    {
        /**
         * @var Controller $instance
         */
        $instance = new $this->controller(
            $this->app,
            $this->app->getRequest(),
            $this->app->getResponse()
        );

        if ( ! empty( $this->middlewares ) || ! empty( $this->middleware ) ) {
            $this->handleMiddleware( $this->args );
        }

        $instance->handle( ...$this->args );
    }

    /**
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

}
