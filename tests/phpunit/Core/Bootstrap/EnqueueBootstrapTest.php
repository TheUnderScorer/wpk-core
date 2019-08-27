<?php

namespace UnderScorer\Core\Tests\Core\Bootstrap;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Bootstrap\EnqueueBootstrap;
use UnderScorer\Core\Enqueue;
use UnderScorer\Core\Tests\TestCase;

/**
 * Class EnqueueBootstrapTest
 * @package UnderScorer\Core\Tests\Core\Bootstrap
 */
class EnqueueBootstrapTest extends TestCase
{

    /**
     * @throws BindingResolutionException
     */
    public function testBootstrap(): void
    {
        $bootstrap = new EnqueueBootstrap( self::$app, __DIR__ . '/files/' );
        $bootstrap->bootstrap();

        $enqueue = self::$app->make( Enqueue::class );
        $scripts = $enqueue->getScripts();

        $this->assertEquals(
            'test_script',
            $scripts[ 0 ][ 'slug' ]
        );
    }
}
