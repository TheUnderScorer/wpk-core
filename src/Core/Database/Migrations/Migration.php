<?php

namespace UnderScorer\Core\Database\Migrations;

use Closure;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Grammars\Grammar;
use UnderScorer\Core\Utility\Strings;
use UnderScorer\ORM\Eloquent\Database;

/**
 * Handles table migration
 *
 * @author Przemysław Żydek
 */
abstract class Migration
{

    /**
     * @var Database
     */
    private $connection;

    /**
     * @var Grammar
     */
    private $grammar;

    /**
     * Migration constructor.
     *
     * @param ConnectionInterface $connection
     * @param Grammar             $grammar
     */
    public function __construct( ConnectionInterface $connection, Grammar $grammar )
    {
        $this->connection = $connection;
        $this->grammar    = $grammar;
    }

    /**
     * Migrates table
     *
     * @return void
     */
    abstract public function up(): void;

    /**
     * Cleanups table
     *
     * @return void
     */
    abstract public function down(): void;

    /**
     * Returns table name (without prefix)
     *
     * @return string
     */
    abstract public function getTable(): string;

    /**
     * @return Database
     */
    public function getConnection(): Database
    {
        return $this->connection;
    }

    /**
     * @param Database $connection
     *
     * @return Migration
     */
    public function setConnection( Database $connection ): self
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @return Grammar
     */
    public function getGrammar(): Grammar
    {
        return $this->grammar;
    }

    /**
     * @param Grammar $grammar
     *
     * @return Migration
     */
    public function setGrammar( Grammar $grammar ): self
    {
        $this->grammar = $grammar;

        return $this;
    }

    /**
     * Creates table blueprint
     *
     * @param string  $table
     * @param Closure $callback
     *
     * @return void
     */
    final protected function create( string $table, Closure $callback ): void
    {
        $prefixedTable = $this->getTableName( $table );

        $blueprint = new Blueprint( $prefixedTable );

        try {
            $this->connection->table( $table )->count( '*' );
        } catch ( QueryException $e ) {
            if ( Strings::contains( $e->getMessage(), 'doesn\'t exist' ) ) {
                $blueprint->create();
            }
        }

        $callback( $blueprint );

        $sql = $blueprint->toSqlString( $this->connection, $this->grammar );

        foreach ( $sql as $query ) {
            $this->connection->statement( $query );
        }
    }

    /**
     * @param string $table
     *
     * @return string
     */
    protected function getTableName( string $table ): string
    {
        $prefix = $this->connection->db->prefix;

        return $prefix . $table;
    }

    /**
     * @param string $table
     *
     * @return void
     */
    final protected function drop( string $table ): void
    {
        $prefixedTable = $this->getTableName( $table );

        $this->connection->statement( "DROP TABLE IF EXISTS $prefixedTable" );
    }

}
