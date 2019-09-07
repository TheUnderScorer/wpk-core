<?php

namespace UnderScorer\Core\Tests\Http;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Http\Router;
use UnderScorer\Core\Tests\TestCase;

/**
 * Class RouterTest
 * @package UnderScorer\Core\Tests\Http
 */
class RouterTest extends TestCase
{

    /**
     * @throws BindingResolutionException
     */
    public function testRoute()
    {
        $router = self::$app->make( Router::class );
        $route  = $router->route();

        $this->assertEquals( $router, $route->end() );
    }
}
