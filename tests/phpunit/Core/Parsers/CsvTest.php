<?php

namespace UnderScorer\Core\Tests\Core\Parsers;

use Exception;
use UnderScorer\Core\Parsers\Csv;
use UnderScorer\Core\Tests\TestCase;

/**
 * @author Przemysław Żydek
 */
final class CsvTest extends TestCase
{

    /** @var array */
    const CSV_COLUMNS = [
        'firstName',
        'lastName',
        'email',
        'login',
        'company',
        'ID',
        'groups',
    ];

    /**
     * @covers Csv::parse
     */
    public function testIsParsingCsvFileWithExternalColumns()
    {

        $path = TESTS_DIR . '/Core/Parsers/withoutColumns.csv';

        $csv = Csv::parse( $path, ';', self::CSV_COLUMNS );

        $column = $csv[ 0 ];

        foreach ( self::CSV_COLUMNS as $csvColumn ) {
            $this->assertArrayHasKey( $csvColumn, $column );
        }

        $this->assertEquals( 'KimUpdate', $column[ 'firstName' ] );
        $this->assertEquals( 'JacobsenUpdate', $column[ 'lastName' ] );
        $this->assertEquals( 'kjUpdate@ecco.com', $column[ 'email' ] );
        $this->assertEquals( 'jacobskiNew', $column[ 'login' ] );
        $this->assertEquals( 'Update company', $column[ 'company' ] );
        $this->assertEquals( '14847', $column[ 'ID' ] );
        $this->assertEquals( 'Updated-group', $column[ 'groups' ] );

    }

    /**
     * @covers Csv::parse
     */
    public function testIsThrowingExceptionOnInvalidFilePath()
    {

        $this->setExpectedException( Exception::class, 'Invalid CSV file provided' );

        Csv::parse( 'invalid path' );

    }

}
