<?php

namespace UnderScorer\Core\Utility;

use Illuminate\Support\Str;

/**
 * String related utilities
 *
 * @author Przemysław Żydek
 */
class Strings extends Str
{

    /**
     * Check if string contains many substrings
     *
     * @param string $string
     * @param array  $substrings
     *
     * @return bool
     */
    public static function containsMany( string $string, ...$substrings ): bool
    {

        foreach ( $substrings as $substring ) {
            if ( ! self::contains( $string, $substring ) ) {
                return false;
            }
        }

        return true;

    }

    /**
     * Wraps text into quotes
     *
     * @param string $text
     * @param string $quote
     *
     * @return string
     */
    public static function quote( string $text, string $quote = '"' ): string
    {
        return $quote . $text . $quote;
    }

}
