<?php

namespace UnderScorer\Core\Storage;

use UnderScorer\Core\Tests\TestCase;

/**
 * Class CacheTest
 * @package UnderScorer\Core\Storage
 */
final class CacheTest extends TestCase
{

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @covers \UnderScorer\Core\Storage\Cache::set
     */
    public function testIsCachingAnyValue()
    {

        $value = 'test_value';

        $this->cache->set( 'test', $value );

        $this->assertEquals( $value, $this->cache->get( 'test' ) );

    }

    /**
     * @covers \UnderScorer\Core\Storage\Cache::delete
     */
    public function testIsRemovingValue()
    {

        $value = 'test_value';

        $this->cache->set( 'test', $value );
        $this->cache->delete( 'test' );

        $this->assertEmpty( $this->cache->get( 'test' ) );

    }

    /**
     * @covers \UnderScorer\Core\Storage\Cache::delete
     */
    public function testIsCacheValueBeingRemovedOnTime()
    {

        $value = 'test_value';

        $this->cache->set( 'test', $value );

        sleep( 3 );

        $this->assertEmpty( $this->cache->get( 'test' ) );
        $this->assertTrue( empty( $this->cache->getTransientsKeys() ) );

    }

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->cache = new Cache( 'test', '+2 seconds' );
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        $this->cache->clear();
    }

}
