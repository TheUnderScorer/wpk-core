<?php

namespace UnderScorer\Core\Admin;

use UnderScorer\Core\Contracts\ViewRenderInterface;
use function UnderScorer\Core\view;

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
     * Notices constructor.
     *
     * @param ViewRenderInterface $view
     */
    public function __construct( ViewRenderInterface $view )
    {
        $this->view = $view;;
    }

    /**
     * Adds new admin notice
     *
     * @param string $text
     * @param string $type
     *
     * @return void
     */
    public function add( string $text, string $type = 'notice-info' ): void
    {

        add_action( 'admin_notices', function () use ( $text, $type ) {
            echo $this->view->render( 'admin.notice', [ 'type' => $type, 'text' => $text ] );
        } );

    }

}
