<?php

namespace UnderScorer\Core\Tests\Admin;

use PHPUnit\Framework\MockObject\MockObject;
use Psr\SimpleCache\InvalidArgumentException;
use UnderScorer\Core\Admin\Notices;
use UnderScorer\Core\Storage\TransientCache;
use UnderScorer\Core\Tests\TestCase;
use UnderScorer\Core\View;

/**
 * Class NoticesTest
 * @package UnderScorer\Core\Tests\Admin
 */
final class NoticesTest extends TestCase
{

    /**
     * @var MockObject|View
     */
    protected $mockView;

    /**
     * @var MockObject|TransientCache
     */
    protected $mockCache;

    /**
     * @var Notices
     */
    protected $notices;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->mockView = $this
            ->getMockBuilder( View::class )
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockCache = $this
            ->getMockBuilder( TransientCache::class )
            ->disableOriginalConstructor()
            ->getMock();

        $this->notices = new Notices( $this->mockView, $this->mockCache );
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     *
     */
    public function testAddCachedNotice(): void
    {
        $text = 'My test notice';
        $type = 'notice';

        $this->mockCache->method( 'get' )->willReturn( [] );

        $this
            ->mockCache
            ->expects( $this->once() )
            ->method( 'set' )
            ->with( 'notices', [
                compact( 'text', 'type' ),
            ] );

        $this->notices->addCachedNotice( $text, $type );
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     *
     */
    public function testHandleCachedNotices(): void
    {
        $text = 'My test notice';
        $type = 'notice';

        $this->mockCache->method( 'get' )->willReturn( [
            compact( 'text', 'type' ),
        ] );

        $this
            ->mockView
            ->expects( $this->once() )
            ->method( 'render' )
            ->with( 'admin.notice', compact( 'type', 'text' ) );

        $this->notices->handleCachedNotices();
        do_action( 'admin_notices' );
    }

    /**
     * @return void
     */
    public function testAdd(): void
    {
        $this->mockView->method( 'render' )->willReturn( '' );

        $text = 'My test notice';
        $type = 'notice';

        $this->notices->add( $text, $type );

        $this
            ->mockView
            ->expects( $this->once() )
            ->method( 'render' )
            ->with( 'admin.notice', compact( 'type', 'text' ) );

        do_action( 'admin_notices' );
    }
}
