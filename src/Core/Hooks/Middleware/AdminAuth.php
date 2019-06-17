<?php

namespace UnderScorer\Core\Hooks\Middleware;

/**
 * @author Przemysław Żydek
 */
class AdminAuth implements Middleware
{

    /**
     * @param array $params Optional parameters
     *
     * @return void
     */
    public function handle( array $params = [] )
    {

        if ( ! current_user_can( 'administrator' ) ) {
            wp_die();
        }

    }

}
