<?php

namespace UnderScorer\Core\Tests\Core\Hooks\Controllers\Http;

use UnderScorer\Core\Hooks\Controllers\Http\GetCoreVersionHandler;
use UnderScorer\Core\Http\ResponseTemplates\BaseResponse;
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

        $response = new BaseResponse( $this->makeAjaxCall( GetCoreVersionHandler::class ) );

        $this->assertEquals( CORE_VERSION, $response->result );

    }

}
