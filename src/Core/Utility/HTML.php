<?php

namespace UnderScorer\Core\Utility;

/**
 * @author Przemysław Żydek
 */
class HTML
{

    /**
     * Mark option element as "selected" if option can be found in array of selected options
     *
     * @param array  $selected
     * @param string $option
     *
     * @return string
     */
    public static function selectedMultiple( array $selected, string $option ): string
    {

        if ( ! in_array( $option, $selected ) ) {
            return '';
        }

        return 'selected="selected"';

    }

    /**
     * @param array $data
     *
     * @return string
     */
    public static function buildDataAttributes( array $data ): string
    {

        $result = [];

        foreach ( $data as $key => $value ) {
            $result[] = sprintf( 'data-%s="%s"', $key, $value );
        }

        return implode( ' ', $result );

    }

    /**
     * @param mixed $index
     *
     * @return void
     */
    public static function dynamicSidebar( $index )
    {
        dynamic_sidebar( $index );
    }

}
