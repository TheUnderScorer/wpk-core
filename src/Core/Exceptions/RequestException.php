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
    protected $errorCode = '';

    /**
     * @var int
     */
    protected $statusCode = 500;

    /**
     * RequestException constructor.
     *
     * @param string $message
     * @param string $errorCode
     * @param int    $statusCode
     */
    public function __construct( string $message = '', string $errorCode = 'SERVER_ERROR', int $statusCode = 500 )
    {
        $this->statusCode = $statusCode;
        $this->errorCode  = $errorCode;

        parent::__construct( $message );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'message'    => $this->message,
            'errorCode'  => $this->errorCode,
            'statusCode' => $this->statusCode,
        ];
    }

    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

}
