<?php

namespace UnderScorer\Tests\Core\Hooks\Middleware;

use UnderScorer\Core\Exceptions\ValidationException;
use UnderScorer\Core\Hooks\Middleware\ValidationMiddleware;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\Response;
use UnderScorer\Core\Tests\TestCase;

/**
 * Class HasValidatorTest
 * @package UnderScorer\Core\Tests\Core\Validation
 */
final class ValidationMiddlewareTest extends TestCase
{

    /**
     * @var ValidationMiddleware
     */
    protected $middleware;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->middleware = new ValidationMiddleware(
            self::$app,
            new Request(),
            new Response()
        );
    }


    /**
     * @return void
     * @throws ValidationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testValidate(): void
    {
        $rules = [
            'test'    => 'required',
            'testArr' => 'required|array',
            'testNum' => 'required|numeric',
        ];

        $input = [
            'test'    => null,
            'testArr' => 15,
            'testNum' => 'string',
        ];

        $this->setExpectedException( ValidationException::class, 'Validation error: The Test is required, The TestArr must be array, The TestNum must be numeric' );

        $this->middleware->handle( $input, $rules );
    }
}
