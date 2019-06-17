<?php

namespace UnderScorer\Core\Utility;

/**
 * String related utilities
 *
 * @author Przemysław Żydek
 */
class Strings
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
     * Check if string contains provided substring
     *
     * @param string $string
     * @param string $substring
     *
     * @return bool
     */
    public static function contains( string $string, string $substring ): bool
    {
        return strpos( $string, $substring ) !== false;
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
