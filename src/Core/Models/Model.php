<?php

namespace UnderScorer\Core\Models;

use Closure;
use Exception;
use UnderScorer\Core\Models\Query\MySql\QueryBuilder;
use UnderScorer\Core\Storage\Collection;
use UnderScorer\Core\Utility\AttributeBuilder;
use UnderScorer\Core\Utility\Logger;

/**
 * Simple model for MySql objects
 *
 * @author Przemysław Żydek
 */
abstract class Model implements ModelInterface
{

    use AttributeBuilder;

    /**
     * @var string
     */
    const TABLE = '';

    /**
     * @var array Contains optional fields aliases
     */
    const ALIASES = [
        'title' => 'modelTitle',
    ];

    /**
     * @var int
     */
    public $id;

    /**
     * SimpleModel constructor.
     *
     * @param array $data
     */
    public function __construct( array $data = [] )
    {
        $this->parseAttributes( $data );
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode( $this->toArray() );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter( get_object_vars( $this ) );
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->id;
    }

    /**
     * @param int $page
     * @param int $perPage
     *
     * @return Collection
     */
    public static function getItems( int $page = 1, int $perPage = 20 ): Collection
    {

        $page   -= 1;
        $offset = $page > 0 ? $perPage * $page : 0;

        $builder = static::getQueryBuilder();
        $query   = $builder
            ->select()
            ->limit( $offset, $perPage );

        $results = $builder->getResults( $query );

        return $results;

    }

    /**
     * Get query instance for this model
     *
     * @return QueryBuilder
     */
    public static function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder( static::getTable(), static::class );
    }

    /**
     * @return string
     */
    public static function getTable(): string
    {

        global $wpdb;

        return $wpdb->prefix . static::TABLE;

    }

    /**
     * @param Closure $callback
     *
     * @return bool
     * @throws Exception
     */
    public static function query( Closure $callback )
    {
        $builder = static::getQueryBuilder();

        return $builder->query( $callback( $builder ) );
    }

    /**
     * @param Closure $callback
     *
     * @return Collection
     */
    public static function getResults( Closure $callback ): Collection
    {
        $builder = static::getQueryBuilder();

        return $builder->getResults( $callback( $builder ) );
    }

    /**
     * @param Closure $callback
     *
     * @return mixed
     */
    public static function getRow( Closure $callback )
    {
        $builder = static::getQueryBuilder();

        return $builder->getRow( $callback( $builder ) );
    }

    /**
     * Perform "LIKE" search
     *
     * @param string $column
     * @param string $keyword
     * @param string $wildCard Determines where wildcard should be added (end, start, both)
     *
     * @return Collection
     */
    public static function like( string $column, string $keyword, string $wildCard = 'both' ): Collection
    {

        $builder = static::getQueryBuilder();
        $query   = $builder->select()
                           ->where()
                           ->like( $column, $keyword, $wildCard )
                           ->end();

        return $builder->getResults( $query );

    }

    /**
     * Makes collection of models from arrays of data
     *
     * @param array $datas
     *
     * @return Collection
     */
    public static function makeFromArray( array $datas ): Collection
    {

        $result = [];

        foreach ( $datas as $item ) {
            $result[] = new static( $item );
        }

        return Collection::make( $result );

    }

    /**
     * Remove all records from table. Use with caution.
     *
     * @return bool
     * @throws Exception
     */
    public static function removeAll(): bool
    {

        $builder = static::getQueryBuilder();
        $query   = $builder->delete();

        return (bool) $builder->query( $query );

    }

    /**
     * Truncates table. Use with caution.
     *
     * @return bool
     * @throws Exception
     */
    public static function truncate()
    {

        global $wpdb;

        $table = static::getTable();

        $result = (bool) $wpdb->query( "TRUNCATE TABLE $table" );

        if ( ! $result && $wpdb->last_error ) {
            throw new Exception( $wpdb->last_error );
        }

        return true;

    }

    /**
     * @param int $id
     *
     * @return static|bool
     */
    public static function find( int $id )
    {

        $builder = static::getQueryBuilder();
        $query   = $builder->select()
                           ->where()
                           ->equals( 'id', $id )
                           ->end();

        return $builder->getRow( $query );

    }

    /**
     * @return bool
     * @throws Exception
     */
    public function save(): bool
    {

        global $wpdb;

        $result = $wpdb->insert( static::getTable(), $this->toArray() );

        if ( ! $result ) {
            throw new Exception( $wpdb->last_error );
        }

        $this->id = $wpdb->insert_id;

        $class = static::class;
        do_action( "ib/model:{$class}/save", $this );

        return (bool) $result;

    }

    /**
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {

        global $wpdb;

        $result = $wpdb->update( static::getTable(), $this->toArray(), [ 'id' => $this->id ] );

        $triggerHook = function () {
            $class = static::class;

            do_action( "ib/model:{$class}/update", $this );
        };

        if ( ! $result ) {

            if ( $wpdb->last_error ) {
                throw new Exception( $wpdb->last_error );
            }

            $triggerHook();

            return $result === 0;

        }

        $triggerHook();

        return (bool) $result;

    }

    /**
     * @return bool
     */
    public function delete(): bool
    {

        $builder = static::getQueryBuilder();
        $query   = $builder->delete()->where()->equals( 'id', $this->id )->end();

        try {
            $result = (bool) $builder->query( $query );
        } catch ( Exception $e ) {
            Logger::logException( $e, __METHOD__ );

            return false;
        }

        $class = static::class;
        do_action( "ib/model:{$class}/delete", $this );

        return $result;

    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count( $this->toArray() );
    }

}
