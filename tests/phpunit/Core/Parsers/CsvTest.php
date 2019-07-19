<?php

namespace UnderScorer\Core\Tests\Core\Parsers;

use UnderScorer\Core\Exceptions\CsvException;
use UnderScorer\Core\Parsers\CsvParser;
use UnderScorer\Core\Tests\TestCase;


/**
 * Class CsvTest
 * @package UnderScorer\Core\Tests\Core\Parsers
 */
final class CsvTest extends TestCase
{

    /**
     * @var array
     */
    protected $columns = [
        'firstName',
        'lastName',
        'email',
        'login',
        'company',
        'ID',
        'groups',
    ];

    /**
     * @covers CsvParser::parse
     */
    public function testIsParsingCsvFileWithExternalColumns()
    {

        $path   = TESTS_DIR . '/Core/Parsers/withoutColumns.csv';
        $parser = new CsvParser( $path, ';', $this->columns );

        $csv = $parser->parse();

        $column = $csv[ 0 ];

        foreach ( $this->columns as $csvColumn ) {
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
     * @covers CsvParser::parse
     * @throws CsvException
     */
    public function testIsThrowingExceptionOnInvalidFilePath()
    {
        $this->setExpectedException( CsvException::class, 'Invalid CSV file provided' );

        $parser = new CsvParser( 'invalid' );
        $parser->parse();
    }

}
