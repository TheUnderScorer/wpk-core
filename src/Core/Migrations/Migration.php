<?php

namespace UnderScorer\Core\Migrations;

use wpdb;

/**
 * Handles table migration
 *
 * @author Przemysław Żydek
 */
abstract class Migration
{

    /**
     * @var string Name of the table
     */
    const TABLE = '';

    /**
     * @var wpdb Stores reference to wpdb instance
     */
    protected static $wpdb;

    /**
     * @var string[] Array of child classes for migration
     */
    private static $migrations = [];

    /**
     * Migration constructor.
     */
    public function __construct()
    {

        global $wpdb;

        if ( empty( self::$wpdb ) ) {
            self::$wpdb = $wpdb;
        }

    }

    /**
     * Handles migration of child classes
     *
     * @return void
     */
    final public static function migrations()
    {

        foreach ( self::$migrations as $migration ) {

            /**
             * @var self $instance
             */
            $instance = new $migration;
            $instance->migrate();

        }

    }

    /**
     * Handles table migration
     *
     * @return void
     */
    abstract public function migrate();

    /**
     * @return string
     */
    final protected function getTableName(): string
    {
        return $this->getPrefix() . static::TABLE;
    }

    /**
     * @return string
     */
    final protected function getPrefix(): string
    {
        return self::$wpdb->prefix;
    }

    /**
     * Performs dbDelta of provided sql query
     *
     * @param string $query
     *
     * @return array
     */
    final protected function dbDelta( string $query ): array
    {
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        return dbDelta( $query );
    }

}
