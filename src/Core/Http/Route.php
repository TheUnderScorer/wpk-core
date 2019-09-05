<?php

namespace UnderScorer\Core\Http;

use TypeRocket\Http\Route as BaseRoute;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Utility\Arr;

/**
 * Class Route
 * @package UnderScorer\Core\Http
 */
class Route extends BaseRoute
{

    /**
     * @var AppInterface
     */
    protected $app;

    /**
     * @var Router
     */
    protected $router;

    /**
     * Route constructor.
     *
     * @param AppInterface $app
     * @param Router       $router
     */
    public function __construct( AppInterface $app, Router $router )
    {
        $this->app    = $app;
        $this->router = $router;
    }

    /**
     * @param string $controller
     *
     * @return Route
     */
    public function controller( string $controller ): self
    {
        $this->do( function () use ( $controller ) {
            $this->handleRoute( func_get_args(), $controller );
        } );

        return $this;
    }

    /**
     * Handles current route
     *
     * @param array  $args Args fetched from url path
     * @param string $controller
     */
    protected function handleRoute( array $args, string $controller ): void
    {
        $kernel = new Kernel(
            $controller,
            $args,
            is_array( $this->middleware ) ? $this->middleware : Arr::make( $this->middleware ),
            $this->app,
        );

        $kernel->bootstrap();
    }

    /**
     * @return Router
     */
    public function end(): Router
    {
        return $this->router;
    }

}
