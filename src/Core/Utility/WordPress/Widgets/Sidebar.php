<?php

namespace UnderScorer\Core\Utility\WordPress\Widgets;

/**
 * @author Przemysław Żydek
 */
class Sidebar
{

    /**
     * Get widgets for provided sidebar
     *
     * @param string $sidebarID
     *
     * @return array
     */
    public static function getWidgets( string $sidebarID ): array
    {

        global $wp_registered_sidebars, $wp_registered_widgets, $_wp_sidebars_widgets;

        $result = [];

        $sidebarWidgets = $_wp_sidebars_widgets;

        if ( ! isset( $sidebarWidgets[ $sidebarID ] ) || ! isset( $wp_registered_sidebars[ $sidebarID ] ) ) {
            return [];
        }

        $targetSidebarWidgets = $sidebarWidgets[ $sidebarID ];

        foreach ( $targetSidebarWidgets as $id ) {

            if ( isset( $wp_registered_widgets[ $id ] ) ) {
                // We fetch widget instance from it's callback
                $result[] = $wp_registered_widgets[ $id ][ 'callback' ][ 0 ];
            }

        }

        return $result;

    }

}
