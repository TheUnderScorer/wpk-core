<?php

namespace UnderScorer\Core\Tests\Core\Hooks\Controllers\Http;

use UnderScorer\Core\Hooks\Controllers\Http\GetCoreVersionHandler;
use UnderScorer\Core\Tests\HttpTestCase;

/**
 * Class GetCoreVersionHandlerTest
 * @package UnderScorer\Core\Tests\Core\Hooks\Controllers\Http
 */
class GetCoreVersionHandlerTest extends HttpTestCase
{

    /**
     * @return void
     */
    public function testIsReturningCoreVersion(): void
    {
        $response = json_decode( $this->makeAjaxCall( GetCoreVersionHandler::class ), true );

        $this->assertEquals( CORE_VERSION, $response[ 'result' ] );
    }

}
