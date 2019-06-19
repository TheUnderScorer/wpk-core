<?php

namespace UnderScorer\Core\Http\ResponseTemplates;

use Exception;
use UnderScorer\Core\Exceptions\RequestException;

/**
 * @author Przemysław Żydek
 */
class ErrorResponse extends BaseResponse
{

    /**
     * @var bool
     */
    protected $error = true;

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var int
     */
    protected $code = 400;

    /**
     * @param Exception $exception
     *
     * @return ErrorResponse
     */
    public function handleException( Exception $exception ): self
    {

        if ( $exception instanceof RequestException ) {
            return $this->addMessage(
                $exception->getMessage(),
                $exception->toArray()
            );
        }

        // At this point we assume that this is internal error
        $this->code = 500;

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

}
