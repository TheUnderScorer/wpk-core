<?php

namespace UnderScorer\Core\Tests\Core\Database\Migrations;

use UnderScorer\Core\Database\Migrations\Blueprint;
use UnderScorer\Core\Database\Migrations\Migration;

/**
 * Class TestMigration
 * @package UnderScorer\Core\Tests\Core\Database\Migrations
 */
class TestMigration extends Migration
{

    /**
     * Migrates table
     *
     * @return void
     */
    public function up(): void
    {
        $this->create( 'test_table', function ( Blueprint $blueprint ) {
            $blueprint->bigIncrements( 'ID' );
            $blueprint->string( 'name', 50 );
            $blueprint->text( 'value' );

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
        $this->drop( 'test_table' );
    }

}
