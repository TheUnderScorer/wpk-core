<?php

namespace UnderScorer\Core\Http\ResponseContents;

use Throwable;
use UnderScorer\Core\Exceptions\RequestException;

/**
 * @author Przemysław Żydek
 */
class ErrorResponseContent extends ResponseContent
{

    /**
     * @var bool
     */
    protected $error = true;

    /**
     * @var string
     */
    protected $errorCode = 'REQUEST_ERROR';

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @param Throwable $exception
     *
     * @return ErrorResponseContent
     */
    public function handleException( Throwable $exception ): self
    {
        if ( $exception instanceof RequestException ) {
            return $this->addMessage(
                $exception->getMessage(),
                $exception->getErrorCode(),
                );
        }

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            return $this->addMessage( $exception->getMessage() );
        }

        return $this->addMessage( 'Internal server error.' );
    }

    /**
     * Adds new message to response
     *
     * @param string $message
     * @param mixed  $code
     * @param array  $args
     *
     * @return self
     */
    public function addMessage( string $message, $code = 'SERVER_ERROR', $args = [] ): self
    {
        $args += [
            'code'    => $code,
            'field'   => '',
            'message' => $message,
        ];

        $this->messages[] = $args;

        return $this;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @param bool $error
     *
     * @return self
     */
    public function setError( bool $error ): self
    {
        $this->error = $error;

        return $this;
    }

}
