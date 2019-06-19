<?php

namespace UnderScorer\Core\Tests\Core\Hooks\Middleware;

use UnderScorer\Core\Hooks\Middleware\FieldsValidator;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\ResponseTemplates\ErrorResponse;
use UnderScorer\Core\Tests\Mock\Http\MockResponse;
use UnderScorer\Core\Tests\TestCase;

/**
 * Class FieldsValidatorTest
 * @package UnderScorer\Core\Tests\Core\Hooks\Middleware
 */
final class FieldsValidatorTest extends TestCase
{

    /**
     * @covers \UnderScorer\Core\Hooks\Middleware\FieldsValidator::handle
     */
    public function testIsNotFailingIfFieldValueIsSet()
    {
        $request  = new Request();
        $response = new MockResponse();

        $request->request->set( 'testField', true );

        $middleware = new FieldsValidator( self::$app, $request, $response );
        $middleware->handle( 'body', [ 'testField' ] );

        $this->assertEmpty( $response->getSentResponses() );
    }

    /**
     * @covers \UnderScorer\Core\Hooks\Middleware\FieldsValidator::handle
     */
    public function testIsCheckingEmptyRequiredFieldFromBody()
    {
        $this->checkFieldEmpty( 'body' );
    }

    /**
     * @param string $source
     */
    protected function checkFieldEmpty( string $source ): void
    {
        $request  = new Request();
        $response = new MockResponse();

        $middleware = new FieldsValidator( self::$app, $request, $response );
        $middleware->handle( $source, [ 'testField' ] );

        /**
         * @var ErrorResponse $error
         */
        $error = $response->getSentResponses()[ 0 ];

        $this->assertEquals( 'testField is required.', $error->getMessages()[ 0 ][ 'message' ] );
    }

    /**
     * @covers \UnderScorer\Core\Hooks\Middleware\FieldsValidator::handle
     */
    public function testIsCheckingEmptyRequiredFieldFromCookie()
    {
        $this->checkFieldEmpty( 'cookie' );
    }

    /**
     * @covers \UnderScorer\Core\Hooks\Middleware\FieldsValidator::handle
     */
    public function testIsCheckingEmptyRequiredFieldFromQuery()
    {
        $this->checkFieldEmpty( 'cookie' );
    }

}
