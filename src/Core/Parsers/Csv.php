<?php

namespace UnderScorer\Core\Parsers;

use Exception;

/**
 * @author Przemysław Żydek
 */
class Csv implements Parser
{

    /**
     * Parses CSV file to associative array
     *
     * @param string $path
     * @param string $delimiter
     * @param array  $columns Optional CSV columns
     *
     * @return array
     *
     * @throws Exception
     */
    public static function parse( $path, string $delimiter = ';', array $columns = [] )
    {

        $csv = self::getCsv( $path, $delimiter );

        $externalColumns = ! empty( $columns );

        if ( empty( $csv ) ) {
            throw new Exception( 'Invalid CSV file provided' );
        }

        if ( ! $externalColumns ) {
            $columns = $csv[ 0 ];
        }

        $csv = array_map( function ( $item ) use ( $csv, $columns ) {
            return array_combine( $columns, $item );
        }, $csv );

        if ( ! $externalColumns ) {
            array_shift( $csv );
        }

        return $csv;

    }

    /**
     * @param string $path
     * @param string $delimiter
     *
     * @return array|null
     */
    private static function getCsv( string $path, string $delimiter )
    {

        return array_map( function ( $item ) use ( $delimiter ) {
            return str_getcsv( $item, $delimiter );
        }, file( $path ) );

    }

}
