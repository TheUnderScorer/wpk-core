<?php

namespace UnderScorer\Core\Hooks\Controllers\Dev;

use UnderScorer\Core\Hooks\Controllers\Controller;

/**
 * Class ErrorHandler
 * @package UnderScorer\Core\Hooks\Controllers\Dev
 */
class ErrorHandler extends Controller
{

    /**
     * @var array
     */
    protected $errorCodes = [ E_USER_ERROR, E_USER_NOTICE ];

    /**
     * @param int    $errno
     * @param string $error
     * @param string $file
     * @param int    $line
     * @param array  $context
     *
     * @return bool
     */
    public function handle( int $errno, string $error, string $file = '', int $line = 0, array $context = [] ): bool
    {
        $email = getenv( 'DEV_EMAIL' );

        if ( ! ( error_reporting() & $errno ) || ! in_array( $errno, $this->errorCodes ) || empty( $email ) ) {
            // This error code is not included in error_reporting, so let it fall
            // through to the standard PHP error handler
            return false;
        }

        $title   = sprintf( 'Error occured on %s.', $this->request->server->get( 'HTTP_HOST' ) );
        $message = "Following error occured: $error in file $file on line $line. Error context: \n";

        ob_start();
        var_export( $context );
        $message .= ob_get_clean();

        if ( ! function_exists( 'wp_mail' ) ) {
            require_once ABSPATH . '/wp-includes/pluggable.php';
        }

        wp_mail(
            $email,
            $title,
            $message
        );

        return true;
    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    protected function setup(): void
    {
        set_error_handler( [ $this, 'handle' ] );
    }
}
