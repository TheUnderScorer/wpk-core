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

        if ( ! defined( 'IS_GRAPHQL' ) || ! IS_GRAPHQL ) {
            if ( ! function_exists( 'wp_mail' ) ) {
                require_once ABSPATH . '/wp-includes/pluggable.php';
            }

            wp_mail(
                $email,
                $title,
                $message
            );
        }

        if ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'IS_GRAPHQL' ) && IS_GRAPHQL ) ) {
            wp_die( $throwable->getMessage(), 'Server error', [
                'code'     => $throwable->getCode(),
                'response' => apply_filters( 'wpk.exception.responseCode', 500, $throwable ),
            ] );
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
