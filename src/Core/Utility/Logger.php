<?php

namespace UnderScorer\Core\Utility;

use Exception;

/**
 * @author Przemysław Żydek
 */
class Logger
{

    /** @var string Key for wp_option */
    const OPTION_SLUG = 'wpk_logs';

    /** @var string Expiration of logs */
    const EXPIRATION = '+30 minutes';

    /**
     * @param Exception $e
     * @param string    $context
     *
     * @return bool
     */
    public static function logException( Exception $e, string $context = '' ): bool
    {
        return self::log( $e->getMessage(), $context, 'error' );
    }

    /**
     * Perform log
     *
     * @param mixed  $userLog
     * @param string $title
     * @param string $type
     *
     * @return bool
     */
    public static function log( $userLog, string $title = '', string $type = 'message' ): bool
    {

        $logs = self::getLogs();

        $date = date( 'd-m-Y H:i:s' );

        $log = '';

        if ( ! empty( $title ) ) {
            $log .= "[$title] ";
        }

        if ( is_array( $userLog ) || is_object( $userLog ) ) {

            ob_start();

            var_export( $userLog );

            $log .= ob_get_clean();

        } else {
            $log .= $userLog;
        }

        $logs[ 'logs' ][] = [
            'date' => $date,
            'log'  => $log,
            'type' => $type,
        ];

        return self::updateLogs( $logs );

    }

    /**
     * @return array
     */
    public static function getLogs(): array
    {

        $default = [
            'logs'   => [],
            'expire' => strtotime( self::EXPIRATION ),
        ];

        $option = get_option( self::OPTION_SLUG, $default );

        if ( time() > $option[ 'expire' ] || empty( $option[ 'expire' ] ) ) {
            delete_option( self::OPTION_SLUG );

            return self::getLogs();
        }

        return $option;

    }

    /**
     * @param array $logs
     *
     * @return bool
     */
    protected static function updateLogs( array $logs ): bool
    {
        return update_option( self::OPTION_SLUG, $logs );
    }

}
