<?php

namespace UnderScorer\Core\Loggers;

use Psr\Log\LoggerInterface;
use UnderScorer\Core\Utility\Date;

/**
 * Class DebugLogger
 * @package UnderScorer\Core\Loggers
 */
class DebugLogger implements LoggerInterface
{

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function emergency( $message, array $context = [] )
    {
        $this->log( 'emergency', $message, $context );
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log( $level, $message, array $context = [] )
    {
        do_action( "wpk/core/log/$level", $level, $message, $context, $this );
        do_action( 'wpk/core/log', $level, $message, $context, $this );

        $now = Date::now()->toDateTimeString();
        $log = "$now [$level]";

        if ( empty( $context ) ) {
            $context = debug_backtrace();
        }

        if ( is_array( $message ) ) {
            ob_start();
            var_export( $message );

            $message = ob_get_clean();
        }

        $log .= " $message";

        error_log( $log );

        ob_start();
        var_export( $context );
        error_log( ob_get_clean() );
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function alert( $message, array $context = [] )
    {
        $this->log( 'alert', $message, $context );
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function critical( $message, array $context = [] )
    {
        $this->log( 'critical', $message, $context );
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function error( $message, array $context = [] )
    {
        $this->log( 'error', $message, $context );
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function warning( $message, array $context = [] )
    {
        $this->log( 'warning', $message, $context );
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function notice( $message, array $context = [] )
    {
        $this->log( 'notice', $message, $context );
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function info( $message, array $context = [] )
    {
        $this->log( 'info', $message, $context );
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function debug( $message, array $context = [] )
    {
        $this->log( 'debug', $message, $context );
    }

}
