<?php

namespace UnderScorer\Core\Tests\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use UnderScorer\Core\Contracts\ViewRenderInterface;
use UnderScorer\Core\Tests\TestCase;
use UnderScorer\Core\View;

/**
 * Class ViewProviderTest
 * @package UnderScorer\Core\Tests\Providers
 */
final class ViewProviderTest extends TestCase
{

    /**
     * @throws BindingResolutionException
     */
    public function testRegister(): void
    {
        /** @var View $view */
        $view     = self::$app->make( ViewRenderInterface::class );
        $viewCopy = self::$app->make( ViewRenderInterface::class );

        $this->assertInstanceOf( View::class, $view );
        $this->assertEquals( $view, $viewCopy );

        $this->assertEquals(
            self::$app->getPath( 'views' ),
            $view->getPath()
        );
    }

}
