<?php

namespace UnderScorer\Core\Exceptions;

use Rakit\Validation\ErrorBag;
use Rakit\Validation\Validation;

/**
 * Class ValidationException
 * @package UnderScorer\Core\Exceptions
 */
class ValidationException extends Exception
{

    /**
     * @var ErrorBag
     */
    protected $errors;

    /**
     * ValidationException constructor.
     *
     * @param Validation $validation
     */
    public function __construct( Validation $validation )
    {
        $this->errors = $validation->errors();

        $message = 'Validation error: ' . implode( ', ', $this->errors->firstOfAll() );

        parent::__construct( $message );
    }

    /**
     * @return ErrorBag
     */
    public function getErrors()
    {
        return $this->errors;
    }

}
