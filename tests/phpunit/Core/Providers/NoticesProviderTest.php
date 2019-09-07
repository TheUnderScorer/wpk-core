<?php

namespace UnderScorer\Core\Tests\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Admin\Notices;
use UnderScorer\Core\Tests\TestCase;

/**
 * Class NoticesProviderTest
 * @package UnderScorer\Core\Tests\Providers
 */
final class NoticesProviderTest extends TestCase
{

    /**
     * @throws BindingResolutionException
     */
    public function testRegister(): void
    {
        $notices     = self::$app->make( Notices::class );
        $noticesCopy = self::$app->make( Notices::class );

        $this->assertInstanceOf( Notices::class, $notices );
        $this->assertEquals( $notices, $noticesCopy );
    }
}
