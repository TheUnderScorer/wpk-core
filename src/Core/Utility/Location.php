<?php

namespace UnderScorer\Core\Utility;

/**
 * @author Przemysław Żydek
 */
class Location
{

    /**
     * @var string
     */
    const BASE_GOOGLE_MAPS_URL = 'https://www.google.com/maps/search/?api=1&query=%s,%s';

    /**
     * @param float $lat
     * @param float $lng
     *
     * @return string
     */
    public static function getGoogleMapUrl( float $lat, float $lng ): string
    {
        return sprintf( self::BASE_GOOGLE_MAPS_URL, $lat, $lng );
    }

}
