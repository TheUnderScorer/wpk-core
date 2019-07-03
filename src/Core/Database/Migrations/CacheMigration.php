<?php

namespace UnderScorer\Core\Database\Migrations;

/**
 * Class CacheMigration
 * @package UnderScorer\Core\Migrations
 */
class CacheMigration extends Migration
{

    /**
     * Migrates table
     *
     * @return void
     */
    public function up(): void
    {
        $this->create( 'cache', function ( Blueprint $blueprint ) {
            $blueprint->bigIncrements( 'ID' );
            $blueprint->string( 'name', 50 );
            $blueprint->longText( 'value' );

            $blueprint->primary( 'ID' );
        } );
    }

    /**
     * Cleanups table
     *
     * @return void
     */
    public function down(): void
    {
        $this->drop( 'cache' );
    }
}
