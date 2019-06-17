<?php

namespace UnderScorer\Core\Exceptions;

use Exception;
use Throwable;
use WP_Error;

/**
 * @author Przemysław Żydek
 */
class WPErrorException extends Exception
{

    /**
     * WPErrorException constructor.
     *
     * @param WP_Error  $error
     * @param Throwable $previous
     */
    public function __construct( WP_Error $error, Throwable $previous = null )
    {
        parent::__construct( $error->get_error_message() );
    }

}
