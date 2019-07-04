<?php

namespace UnderScorer\Core\Validation;

use Rakit\Validation\Validator;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Exceptions\ValidationException;

/**
 * Trait HasValidator
 * @package UnderScorer\Core\Validation
 *
 * @property AppInterface $app
 */
trait HasValidator
{

    /**
     * @param array $input
     * @param array $rules
     *
     * @throws ValidationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function validate( array $input, array $rules ): void
    {
        $validator  = $this->app->make( Validator::class );
        $validation = $validator->make( $input, $rules );

        $validation->validate();

        if ( $validation->fails() ) {
            throw new ValidationException( $validation );
        }
    }

}
