<?php

namespace UnderScorer\Core\Exceptions;

use Exception;
use Throwable;
use UnderScorer\Core\Http\Guzzle\Response;

/**
 * @author Przemysław Żydek
 */
class InvalidApiResponseException extends Exception
{

    /** @var Response */
    protected $response;

    /**
     * InvalidApiResponseException constructor.
     *
     * @param Response       $response
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct( Response $response, int $code = 0, Throwable $previous = null )
    {

        $message = "Invalid response received: {$response->toJson()}";
        parent::__construct( $message, $code, $previous );

        $this->response = $response;

    }

    /**
     * Get invalid response from exception
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

}
