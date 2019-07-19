<?php

namespace UnderScorer\Core\Exceptions;

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
     * @var int
     */
    protected $statusCode = 500;

    /**
     * RequestException constructor.
     *
     * @param string $message
     * @param int    $statusCode
     * @param string $field
     */
    public function __construct( string $message = '', int $statusCode = 500, $field = '' )
    {
        $this->statusCode = $statusCode;
        $this->field      = $field;

        parent::__construct( $message );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'field'      => $this->field,
            'message'    => $this->message,
            'code'       => $this->code,
            'statusCode' => $this->statusCode,
        ];
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

}
