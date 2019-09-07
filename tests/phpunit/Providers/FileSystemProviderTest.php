<?php

namespace UnderScorer\Core\Tests\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Filesystem\Filesystem;
use UnderScorer\Core\Tests\TestCase;

/**
 * Class FileSystemProviderTest
 * @package UnderScorer\Core\Tests\Providers
 */
final class FileSystemProviderTest extends TestCase
{

    /**
     * @throws BindingResolutionException
     */
    public function testRegister(): void
    {
        $fs     = self::$app->make( Filesystem::class );
        $fsCopy = self::$app->make( Filesystem::class );

        $this->assertInstanceOf( Filesystem::class, $fs );
        $this->assertEquals( $fs, $fsCopy );
    }
}
