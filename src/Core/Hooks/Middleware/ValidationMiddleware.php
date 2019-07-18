<?php

namespace UnderScorer\Core\Hooks\Middleware;

use Illuminate\Contracts\Container\BindingResolutionException;
use Rakit\Validation\Validator;
use UnderScorer\Core\Exceptions\ValidationException;

/**
 * Class ValidationMiddleware
 * @package UnderScorer\Core\Hooks\Middleware
 */
class ValidationMiddleware extends Middleware
{

    /**
     * Calls middleware
     *
     * @param array $input
     * @param array $rules
     *
     * @return mixed
     * @throws ValidationException
     * @throws BindingResolutionException
     */
    public function handle( array $input = [], array $rules = [] )
    {
        $validator  = $this->app->make( Validator::class );
        $validation = $validator->make( $input, $rules );

        $validation->validate();

        if ( $validation->fails() ) {
            throw new ValidationException( $validation );
        }
    }

}
