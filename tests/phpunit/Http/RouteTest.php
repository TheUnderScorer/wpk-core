<?php

namespace UnderScorer\Core\Tests\Http;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Http\Route;
use UnderScorer\Core\Http\Router;
use UnderScorer\Core\Tests\TestCase;

/**
 * Class RouteTest
 * @package UnderScorer\Core\Tests\Http
 */
final class RouteTest extends TestCase
{

    /**
     * @throws BindingResolutionException
     */
    public function testEnd()
    {
        $route = self::$app->make( Route::class );

        $this->assertInstanceOf( Router::class, $route->end() );
    }
}
