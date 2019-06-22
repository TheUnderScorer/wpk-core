<?php

namespace UnderScorer\Core\Tests\Core\Hooks\Controllers\Cleaners;

use Exception;
use UnderScorer\Core\Cron\Cleaners\PostCleaner;
use UnderScorer\Core\Tests\TestCase;
use UnderScorer\ORM\WP\Post;

/**
 * Class PostCleanerTest
 * @package UnderScorer\Core\Tests\Core\Cron\Cleaners
 */
final class PostRemovalHandlerTest extends TestCase
{

    /**
     * @covers \UnderScorer\Core\Hooks\Controllers\Cleaners\PostRemovalHandler::handle
     *
     * @throws Exception
     */
    public function testIsRemovingPostOnTime()
    {
        $postID = $this->factory()->post->create();

        do_action( PostCleaner::getCron()->getHook(), $postID );

        $post = Post::query()->find( $postID );

        $this->assertEmpty( $post );
    }

}
