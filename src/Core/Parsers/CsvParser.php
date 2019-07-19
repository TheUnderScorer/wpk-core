<?php

namespace UnderScorer\Core\Parsers;

use Illuminate\Contracts\Support\Arrayable;
use UnderScorer\Core\Exceptions\CsvException;

/**
 * @author Przemysław Żydek
 */
class CsvParser implements Parser, Arrayable
{

    /**
     * @var string Path to csv file
     */
    protected $path;

    /**
     * @var string Delimiter used in csv file
     */
    protected $delimiter;

    /**
     * @var array Optional columns used in CSV file. If empty columns will be fetched from first row
     */
    protected $columns = [];

    /**
     * Csv constructor.
     *
     * @param string $path
     * @param string $delimiter
     * @param array  $columns
     */
    public function __construct( string $path, string $delimiter = ';', array $columns = [] )
    {
        $this->path      = $path;
        $this->delimiter = $delimiter;
        $this->columns   = $columns;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     * @throws CsvException
     */
    public function toArray()
    {
        return $this->parse();
    }

    /**
     * Parses CSV file to associative array
     *
     * @return array
     *
     * @throws CsvException
     */
    public function parse(): array
    {
        $columns = $this->columns;

        $csv = $this->getCsv();

        $externalColumns = ! empty( $columns );

        if ( empty( $csv ) ) {
            throw new CsvException( 'Invalid CSV file provided' );
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
     * @return array|null
     */
    private function getCsv(): ?array
    {
        return array_map( function ( $item ) {
            return str_getcsv( $item, $this->delimiter );
        }, file( $this->path ) );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return self
     */
    public function setPath( string $path ): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     *
     * @return self
     */
    public function setDelimiter( string $delimiter ): self
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     *
     * @return self
     */
    public function setColumns( array $columns ): self
    {
        $this->columns = $columns;

        return $this;
    }
}
