<?php

namespace UnderScorer\Core\Tests\Core\Validation;

use PHPUnit\Framework\MockObject\MockObject;
use UnderScorer\Core\Exceptions\ValidationException;
use UnderScorer\Core\Tests\TestCase;
use UnderScorer\Core\Validation\HasValidator;

/**
 * Class HasValidatorTest
 * @package UnderScorer\Core\Tests\Core\Validation
 */
final class HasValidatorTest extends TestCase
{

    /**
     * @var MockObject|HasValidator
     */
    protected $mock;

    /**
     * @throws \ReflectionException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->mock      = $this->getMockForTrait( HasValidator::class );
        $this->mock->app = self::$app;
    }

    /**
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

        $this->mock->validate( $input, $rules );
    }
}
