<?php

namespace UnderScorer\Core\Exceptions;

use Exception;
use Illuminate\Contracts\Support\Arrayable;


/**
 * @author Przemysław Żydek
 */
class RequestException extends Exception implements Arrayable
{

    /**
     * @var string
     */
    protected $field = '';

    /**
     * RequestException constructor.
     *
     * @param string $message
     * @param string $code
     * @param string $field
     */
    public function __construct( $message = "", $code = 'ERROR', $field = '' )
    {
        $this->code  = $code;
        $this->field = $field;

        parent::__construct( $message );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'field'   => $this->field,
            'message' => $this->message,
            'code'    => $this->code,

        ];
    }


}
