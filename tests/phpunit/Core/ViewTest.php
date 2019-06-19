<?php

namespace UnderScorer\Core\Tests\Core;

use Symfony\Component\Filesystem\Filesystem;
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
     */
    public function testIsRenderingProperly()
    {

        /** @var View $view */
        $view = self::$app->getContainer()->get( View::class );

        $output = $view->render( 'test', [ 'name' => 'Przemek' ] );

        $this->assertEquals( 'Hello Przemek', trim( $output ) );

    }

    /**
     * @throws FileException
     *
     * @covers \UnderScorer\Core\View::createCacheDirectory
     */
    public function testShouldCreateCacheDirectoryIfItDoesNotExist()
    {

        /**
         * @var Filesystem $fileSystem
         */
        $fileSystem = self::$app->getContainer()->get( Filesystem::class );

        $cacheDir = self::$app->getPath( 'views/cache_test' );
        $this->assertFalse( $fileSystem->exists( $cacheDir ) );

        new View( $fileSystem, self::$app->getPath( 'views' ), $cacheDir );
        $this->assertTrue( $fileSystem->exists( $cacheDir ) );

        $fileSystem->remove( $cacheDir );

    }

}
