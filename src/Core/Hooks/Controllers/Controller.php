<?php

namespace UnderScorer\Core\Hooks\Controllers;

use UnderScorer\Core\App;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\View;

/**
 * @author Przemysław Żydek
 */
abstract class Controller
{

    /**
     * @var AppInterface Stores main app instance
     */
    protected $app;

    /**
     * Controller constructor.
     *
     * @param AppInterface $app
     */
    public function __construct( AppInterface $app )
    {

        $this->app = $app;

        $this->setup();

    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    abstract protected function setup(): void;

    /**
     * @param string $path
     * @param array  $data
     *
     * @return string
     */
    protected function render( string $path, array $data = [] ): string
    {

        /**
         * @var View $view
         */
        $view = $this->app->getContainer()->get( View::class );

        return $view->render( $path, $data );

    }

    /**
     * Shorthand for registering new action
     *
     * @param string $hook
     * @param string $callback
     * @param int    $priority
     * @param int    $args
     *
     * @return void
     */
    protected function addAction( string $hook, string $callback, int $priority = 10, int $args = 1 )
    {
        add_action( $hook, [ $this, $callback ], $priority, $args );
    }

    /**
     * Shorthand for registering new filter
     *
     * @param string $hook
     * @param string $callback
     * @param int    $priority
     * @param int    $args
     *
     * @return void
     */
    protected function addFilter( string $hook, string $callback, int $priority = 10, int $args = 1 )
    {
        add_filter( $hook, [ $this, $callback ], $priority, $args );
    }

}
