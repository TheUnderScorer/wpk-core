<?php

namespace UnderScorer\Core\Hooks\Controllers;

/**
 * @author Przemysław Żydek
 */
abstract class AjaxController extends Controller
{

    /**
     * @var string
     */
    protected $hook = '';

    /**
     * @var bool Determines whenever this action is public or not (public is accessable by not logged in users)
     */
    protected $public = false;

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * Perform load of middleware modules
     *
     * @return static
     */
    protected function loadMiddleware()
    {

        foreach ( $this->middleware as $key => $middleware ) {
            $this->middleware[ $key ] = new $middleware( $this->app );

            if ( $middleware instanceof HttpMiddleware ) {
                $middleware->setRequest( $this->request );
                $middleware->setResponse( $this->response );
            }
        }

        return $this;

    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    protected function setup(): void
    {
        add_action( "wp_ajax_$this->hook", [ $this, 'handle' ] );

        if ( $this->public ) {
            add_action( "wp_ajax_nopriv_$this->hook", [ $this, 'handle' ] );
        }
    }

}
