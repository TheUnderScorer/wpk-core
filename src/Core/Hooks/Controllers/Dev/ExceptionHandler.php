<?php

namespace UnderScorer\Core\Hooks\Controllers\Dev;

use Throwable;
use UnderScorer\Core\Hooks\Controllers\Controller;

/**
 * Class ExceptionHandler
 * @package UnderScorer\Core\Hooks\Controllers\Dev
 */
class ExceptionHandler extends Controller
{

    /**
     * @param Throwable $throwable
     */
    public function handle( Throwable $throwable ): void
    {
        $email = getenv( 'DEV_EMAIL' );

        if ( empty( $email ) ) {
            return;
        }

        $title   = sprintf( 'Uncaught excption on %s.', $this->request->server->get( 'HTTP_HOST' ) );
        $message = "Following error occured: {$throwable->getMessage()} in file {$throwable->getFile()} on line {$throwable->getLine()}. Error context: \n";

        ob_start();
        var_export( $throwable->getTrace() );
        $message .= ob_get_clean();

        if ( ! function_exists( 'wp_mail' ) ) {
            require_once ABSPATH . '/wp-includes/pluggable.php';
        }

        wp_mail(
            $email,
            $title,
            $message
        );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            wp_die( "Uncaught exception: {$throwable->getMessage()}" );
        } else {
            wp_die( 'Unknown error occured. We are working on it!', 'Server error', 500 );
        }
    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    protected function setup(): void
    {
        set_exception_handler( [ $this, 'handle' ] );
    }

}
