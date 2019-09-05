<?php

namespace UnderScorer\Core\Http;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Contracts\AppInterface;

/**
 * Class Router
 * @package UnderScorer\Core\Http
 */
class Router
{

    /**
     * @var AppInterface
     */
    protected $app;

    /**
     * Router constructor.
     *
     * @param AppInterface $app
     */
    public function __construct( AppInterface $app )
    {
        $this->app = $app;
    }

    /**
     * @return Route
     * @throws BindingResolutionException
     */
    public function route(): Route
    {
        return $this->app->make( Route::class, [ 'router' => $this ] );
    }

}
