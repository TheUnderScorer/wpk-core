<?php

namespace UnderScorer\Core\Utility;

use Illuminate\Support\Arr as BaseArr;

/**
 * @author Przemysław Żydek
 */
class Arr extends BaseArr
{

    /**
     * Creates new filtered array from provided value
     *
     * @param mixed $value
     *
     * @return array
     */
    public static function make( $value ): array
    {
        return array_filter( (array) $value );
    }

    /**
     * @param string $glue
     * @param array  $array
     *
     * @return string
     */
    public static function implodeRecurr( string $glue, array $array ): string
    {

        $result = [];

        foreach ( $array as $item ) {
            if ( is_array( $item ) ) {
                $result[] = self::implodeRecurr( $glue, $item );
            } else if ( is_serialized( $item ) ) {
                $item     = maybe_unserialize( $item );
                $result[] = self::implodeRecurr( $glue, $item );
            } else {
                $result[] = $item;
            }
        }

        $result = array_filter( $result );
        $result = array_unique( $result );

        return implode( $glue, $result );

    }

}
