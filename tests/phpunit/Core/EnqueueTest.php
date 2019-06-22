<?php

namespace UnderScorer\Core\Tests\Core;

use UnderScorer\Core\Enqueue;
use UnderScorer\Core\Tests\TestCase;

/**
 * Contains Enqueue Wpk\Tests
 */
final class EnqueueTest extends TestCase
{

    /**
     * @covers Enqueue::enqueueScripts
     * @covers Enqueue::enqueueScript
     */
    public function testIsLoadingScriptCorrectly()
    {

        /** @var Enqueue $enqueue */
        $enqueue = self::$app->make(Enqueue::class );

        $enqueue->enqueueScript()->enqueueScripts();

        $this->assertTrue( wp_script_is( self::$app->getSlug() ) );

    }

}
