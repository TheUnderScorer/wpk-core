<?php

namespace UnderScorer\Core\Tests\Core\Database\Migrations;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Tests\TestCase;

/**
 * Class MigrationTest
 * @package UnderScorer\Core\Tests\Core\Database\Migrations
 */
class MigrationTest extends TestCase
{

    /**
     * @var TestMigration
     */
    protected $migration;

    /**
     * @throws BindingResolutionException
     */
    public function setUp()
    {
        parent::setUp();

        $this->migration = self::$app->make( TestMigration::class );
        $this->migration->getConnection()->db->suppress_errors( false );
    }

    /**
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        $this
            ->migration
            ->getConnection()
            ->statement( "DROP TABLE IF EXISTS {$this->migration->getConnection()->db->prefix}test_table" );
    }

    /**
     * @covers \UnderScorer\Core\Database\Migrations\Migration::create
     */
    public function testIsCreatingTableIfItDoesNotExists(): void
    {
        $connection = $this->migration->getConnection();
        $this->migration->up();

        $connection->insert(
            "INSERT INTO {$connection->db->prefix}test_table (name, value) VALUES ('test_name', 'test_value')"
        );

        $row = $connection->table( 'test_table' )->first( '*' );

        $this->assertEquals( 'test_name', $row->name );
        $this->assertEquals( 'test_value', $row->value );
    }

}
