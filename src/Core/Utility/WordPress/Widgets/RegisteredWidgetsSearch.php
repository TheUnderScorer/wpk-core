<?php

namespace UnderScorer\Core\Utility\WordPress\Widgets;

use WP_Widget;

/**
 * @author Przemysław Żydek
 */
class RegisteredWidgetsSearch
{

    /**
     * @param string $numberWithIdBase
     *
     * @return WP_Widget|false
     */
    public static function findByNumberWithIdBase( string $numberWithIdBase )
    {

        global $wp_registered_widgets;

        if ( ! isset( $wp_registered_widgets[ $numberWithIdBase ] ) ) {
            return false;
        }

        // Get widget instance from callback array
        return $wp_registered_widgets[ $numberWithIdBase ][ 'callback' ][ 0 ];

    }

}
