<?php

namespace UnderScorer\Core\Validation;

use Rakit\Validation\Validation as BaseValidation;
use UnderScorer\Core\Exceptions\ValidationException;

/**
 * Class Validation
 * @package UnderScorer\Core\Validation
 */
class Validation extends BaseValidation
{

    /**
     * @throws ValidationException
     */
    public function throwIfFailed(): void
    {
        if ( $this->fails() ) {
            throw new ValidationException( $this );
        }
    }

}
