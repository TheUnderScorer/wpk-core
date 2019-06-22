<?php

namespace UnderScorer\Core\Tests\Core;

use Symfony\Component\Filesystem\Filesystem;
use UnderScorer\Core\Contracts\ViewRenderInterface;
use UnderScorer\Core\Exceptions\FileException;
use UnderScorer\Core\Tests\TestCase;
use UnderScorer\Core\View;

/**
 * Class ViewTest
 * @package UnderScorer\Core\Tests\Core
 */
final class ViewTest extends TestCase
{

    /**
     * @covers \UnderScorer\Core\View::render
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testIsRenderingProperly()
    {

        /** @var View $view */
        $view = self::$app->make(ViewRenderInterface::class );

        $output = $view->render( 'test', [ 'name' => 'Przemek' ] );

        $this->assertEquals( 'Hello Przemek', trim( $output ) );

    }

    /**
     * @throws FileException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @covers \UnderScorer\Core\View::createCacheDirectory
     */
    public function testShouldCreateCacheDirectoryIfItDoesNotExist()
    {

        /**
         * @var Filesystem $fileSystem
         */
        $fileSystem = self::$app->make( Filesystem::class );

        $cacheDir = self::$app->getPath( 'views/cache_test' );
        $this->assertFalse( $fileSystem->exists( $cacheDir ) );

        new View( $fileSystem, self::$app->getPath( 'views' ), $cacheDir );
        $this->assertTrue( $fileSystem->exists( $cacheDir ) );

        $fileSystem->remove( $cacheDir );

    }

}
