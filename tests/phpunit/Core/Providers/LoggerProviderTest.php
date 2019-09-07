<?php

namespace UnderScorer\Core\Tests\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Psr\Log\LoggerInterface;
use UnderScorer\Core\Loggers\DebugLogger;
use UnderScorer\Core\Tests\TestCase;

/**
 * Class LoggerProviderTest
 * @package UnderScorer\Core\Tests\Providers
 */
final class LoggerProviderTest extends TestCase
{

    /**
     * @throws BindingResolutionException
     */
    public function testRegister(): void
    {
        $logger     = self::$app->make( LoggerInterface::class );
        $loggerCopy = self::$app->make( LoggerInterface::class );

        $this->assertInstanceOf( DebugLogger::class, $logger );
        $this->assertEquals( $logger, $loggerCopy );
    }

}
