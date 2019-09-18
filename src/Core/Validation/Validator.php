<?php

namespace UnderScorer\Core\Validation;

use Rakit\Validation\Validator as BaseValidator;
use UnderScorer\Core\Exceptions\ValidationException;

/**
 * Class Validator
 * @package UnderScorer\Core\Validation
 */
class Validator extends BaseValidator
{

    /**
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     *
     * @return Validation
     * @throws ValidationException
     */
    public function validateWithException( array $inputs, array $rules, array $messages = [] ): Validation
    {
        $validation = $this->makeValidation( $inputs, $rules, $messages );
        $validation->validate();
        $validation->throwIfFailed();

        return $validation;
    }

    /**
     * Given $inputs, $rules and $messages to make the Validation class instance
     *
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     *
     * @return Validation
     */
    protected function makeValidation( array $inputs, array $rules, array $messages = [] ): Validation
    {
        $messages   = array_merge( $this->messages, $messages );
        $validation = new Validation( $this, $inputs, $rules, $messages );
        $validation->setTranslations( $this->getTranslations() );

        return $validation;
    }

}
