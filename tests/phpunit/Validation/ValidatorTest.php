<?php

namespace UnderScorer\Core\Tests\Validation;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Exceptions\ValidationException;
use UnderScorer\Core\Tests\TestCase;
use UnderScorer\Core\Validation\Validator;

/**
 * Class ValidatorTest
 * @package UnderScorer\Core\Tests\Validation
 */
final class ValidatorTest extends TestCase
{

    /**
     * @throws ValidationException
     * @throws BindingResolutionException
     */
    public function testValidateWithException(): void
    {
        $validator = self::$app->make( Validator::class );
        $rules     = [
            'ID' => 'integer',
        ];
        $input     = [
            'ID' => 'string',
        ];

        $this->expectException( ValidationException::class );
        $this->expectExceptionMessage( 'Validation error: The ID must be integer' );

        $validator->validateWithException( $input, $rules );
    }
}
