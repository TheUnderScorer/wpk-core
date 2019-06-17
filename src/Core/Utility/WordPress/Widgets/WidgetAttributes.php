<?php

namespace UnderScorer\Core\Utility\WordPress\Widgets;

/**
 * @author Przemysław Żydek
 */
final class WidgetAttributes
{

    /**
     * @param string $fullName
     *
     * @return string
     */
    public static function getWidgetNumberFromFullName( string $fullName ): string
    {

        $idBase = self::getWidgetIdBaseFromFullName( $fullName );

        return str_replace( "{$idBase}-", '', $fullName );

    }

    /**
     * @param string $fullName
     *
     * @return string
     */
    public static function getWidgetIdBaseFromFullName( string $fullName ): string
    {
        return preg_replace( '/-\d/', '', $fullName );
    }

}
