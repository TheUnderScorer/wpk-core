<?php

namespace UnderScorer\Core;

use UnderScorer\Core\Admin\Menu;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Hooks\Controllers\ModuleController;

/**
 * Base module class
 *
 * @author Przemysław Żydek
 */
abstract class Module
{

    /**
     * @var array Array of controllers to load
     */
    protected $controllers = [];

    /**
     * @var AppInterface Related app instance
     */
    protected $app;

    /**
     * @var Menu Stores menu instance
     */
    protected $menu;

    /**
     * @var string Stores unique module ID
     */
    private $ID;

    /**
     * @var bool Determines whenever module have loaded
     */
    private $loaded = false;

    /**
     * Module constructor.
     *
     * @param string       $ID
     * @param AppInterface $app
     *
     */
    public function __construct( string $ID, AppInterface $app )
    {
        $this->ID   = $ID;
        $this->menu = new Menu( $ID );
        $this->app  = $app;

        $app->singleton( static::class, function () {
            return $this;
        } );

        add_action( 'plugins_loaded', function () {

            if ( ! empty( $this->controllers ) ) {
                $this->loadControllers();
            }

            $this->bootstrap();

            $this->loaded = true;

        } );

        do_action( 'wpk.module.init', $this );
    }

    /**
     * @return void
     */
    private function loadControllers(): void
    {
        foreach ( $this->controllers as $controller ) {
            $controllerInstance = new $controller( $this->app );

            $this->app->setupController( $controllerInstance );

            $this->container->add( $controllerInstance );
        }
    }

    /**
     * Performs module bootstrap
     *
     * @return void
     */
    abstract protected function bootstrap(): void;

    /**
     * @return string
     */
    final public function getID(): string
    {
        return $this->ID;
    }

    /**
     * @return Menu
     */
    final public function getMenu(): Menu
    {
        return $this->menu;
    }

}
