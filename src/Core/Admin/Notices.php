<?php

namespace UnderScorer\Core\Admin;

use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UnderScorer\Core\Contracts\ViewRenderInterface;

/**
 * @author Przemysław Żydek
 */
class Notices
{

    /**
     * @var ViewRenderInterface
     */
    protected $view;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Notices constructor.
     *
     * @param ViewRenderInterface $view
     * @param CacheInterface      $cache
     */
    public function __construct( ViewRenderInterface $view, CacheInterface $cache )
    {
        $this->view  = $view;
        $this->cache = $cache;

        add_action( 'admin_init', [ $this, 'handleCachedNotices' ] );
    }

    /**
     * Displays cached notices
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function handleCachedNotices(): void
    {
        $notices = $this->cache->get( 'notices' );

        if ( empty( $notices ) ) {
            return;
        }

        foreach ( $notices as $notice ) {
            $this->add( $notice[ 'text' ], $notice[ 'type' ] ?? 'notice-info' );
        }

        $this->cache->delete( 'notices' );
    }

    /**
     * Adds new admin notice
     *
     * @param string $text
     * @param string $type
     *
     * @return self
     */
    public function add( string $text, string $type = 'notice-info' ): self
    {
        add_action( 'admin_notices', function () use ( $text, $type ) {
            echo $this->view->render( 'admin.notice', [ 'type' => $type, 'text' => $text ] );
        } );

        return $this;
    }

    /**
     * Adds notice into cache. It will be displayed on next page load
     *
     * @param string $text
     * @param string $type
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addCachedNotice( string $text, string $type = 'notice-info' ): self
    {
        $notices = $this->cache->get( 'notices', [] );

        if ( ! is_array( $notices ) ) {
            $notices = [];
        }

        $notices[] = compact( 'text', 'type' );
        $this->cache->set( 'notices', $notices );

        return $this;
    }

}
