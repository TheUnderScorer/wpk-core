<?php

namespace UnderScorer\Core\Tests\Core\Models\WP;

use UnderScorer\Core\Tests\TestCase;
use UnderScorer\ORM\WP\Post;

/**
 * Class PostTest
 * @package UnderScorer\Core\Tests\Core\Models\WP
 */
class PostTest extends TestCase
{

    /**
     * @var Post $post
     */
    protected $post;

    /**
     * @return void
     */
    public function setUp(): void
    {

        parent::setUp();

        $this->post = new Post( [
            'post_title'   => 'Test post',
            'post_content' => 'Test',
        ] );

        $this->post->save();

    }

    /**
     * @covers \UnderScorer\Core\Models\WP\Post::addMeta
     * @covers \UnderScorer\Core\Models\WP\Post::getSingleMeta
     */
    public function testAddMetaGetMetaSingle()
    {

        $this->post->addMeta( 'test', 'test_indeed' );

        $metaValue = $this->post->getSingleMeta( 'test' );

        $this->assertEquals( 'test_indeed', $metaValue->meta_value );

    }

}
