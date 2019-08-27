<?php

namespace UnderScorer\Core\Tests\Core\Hooks\Controllers\Http;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Hooks\Controllers\Http\GetCoreVersionHandler;
use UnderScorer\Core\Tests\Mock\Http\MockResponse;
use UnderScorer\Core\Tests\TestCase;

/**
 * Class GetCoreVersionHandlerTest
 * @package UnderScorer\Core\Tests\Core\Hooks\Controllers\Http
 */
class GetCoreVersionHandlerTest extends TestCase
{

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function testIsReturningCoreVersion(): void
    {
        $mockResponse = new MockResponse();
        $controller   = self::$app->make( GetCoreVersionHandler::class );

        $controller->setResponse( $mockResponse )->handle();

        $response = $mockResponse->getSentResponses()[ 0 ];

        $this->assertEquals( CORE_VERSION, json_decode( $response, true )[ 'result' ] );
    }

}
