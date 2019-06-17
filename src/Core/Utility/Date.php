<?php

namespace UnderScorer\Core\Utility;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;

/**
 * Helper class related to dates
 *
 * @author Przemysław Żydek
 */
class Date extends Carbon
{

    /**
     * @var string
     */
    const DATETIME = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    const DATE = 'Y-m-d';

    /**
     * @var string
     */
    const DISPLAY_DATE = 'd.m.Y';

    /**
     * @var string
     */
    const MYSQL_STR_TO_DATE = '%Y-%m-%d';

    /**
     * Get date range from provided dates and return them in selected format.
     *
     * @param DateTime     $from
     * @param DateTime     $to
     * @param DateInterval $interval
     * @param string       $format
     *
     * @return array
     *
     * @throws Exception
     */
    public static function getDateRange(
        DateTime $from,
        DateTime $to,
        DateInterval $interval,
        string $format = 'Y-m-d'
    ): array {

        $range  = new DatePeriod( $from, $interval, $to );
        $result = [];

        /** @var DateTime $item */
        foreach ( $range as $item ) {
            $result[] = $item->format( $format );
        }

        try {
            $last = new DateTime( end( $result ) );

            $last->modify( 'tomorrow' );
        } catch ( Exception $e ) {

            $currentYear = date( 'Y' );

            $last = new DateTime( $currentYear . '-' . end( $result ) );
            $last->modify( 'tomorrow' );

        }

        $result[] = $last->format( $format );

        return $result;

    }

    /**
     * Get elapsed time string
     *
     * @param bool $full
     *
     * @return string
     */
    public function getTimeElapsed( bool $full = false ): string
    {

        $now  = self::now();
        $diff = $now->diff( $this );

        $diff->w = floor( $diff->d / 7 );
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        foreach ( $string as $k => &$v ) {
            if ( $diff->$k ) {
                $v = $diff->$k . ' ' . $v . ( $diff->$k > 1 ? 's' : '' );
            } else {
                unset( $string[ $k ] );
            }
        }

        if ( ! $full ) {
            $string = array_slice( $string, 0, 1 );
        }

        return $string ? implode( ', ', $string ) . ' ago' : 'just now';

    }

}
