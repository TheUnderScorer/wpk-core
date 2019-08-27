<?php

namespace UnderScorer\Core;

use Closure;
use Illuminate\Container\Container;
use UnderScorer\Core\Bootstrap\BaseBootstrap;
use UnderScorer\Core\Bootstrap\CronsBootstrap;
use UnderScorer\Core\Bootstrap\EnqueueBootstrap;
use UnderScorer\Core\Bootstrap\MigrationsBootstrap;
use UnderScorer\Core\Bootstrap\ModulesBootstrap;
use UnderScorer\Core\Bootstrap\ProvidersBootstrap;
use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Hooks\Controllers\Controller;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\Response;
use UnderScorer\Core\Http\ResponseInterface;
use UnderScorer\Core\Storage\StorageInterface;

/**
 * Core project class
 *
 * @author Przemysław Żydek
 */
class App extends Container implements AppInterface
{

    /**
     * @var string
     */
    const REQUIRED_PHP_VERSION = '7.3';

    /**
     * @var string Slug used for translations
     */
    protected $slug;

    /**
     * @var string Main plugin file
     */
    protected $file;

    /**
     * @var StorageInterface
     */
    protected $settings;

    /**
     * @var string Stores path to this plugin directory
     */
    protected $dir;

    /**
     * @var string Stores url to this plugin directory
     */
    protected $url;

    /**
     * @var array
     */
    protected $bootstrapClasses = [];

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var Request
     */
    private $request;

    /**
     * Core constructor
     *
     * @param string            $slug Plugin slug
     * @param string            $file Main plugin file
     * @param StorageInterface  $settings Settings instance
     * @param array             $bootstrapClasses
     * @param Request           $request
     * @param ResponseInterface $response
     */
    public function __construct(
        string $slug,
        string $file,
        StorageInterface $settings,
        array $bootstrapClasses = [],
        Request $request = null,
        ResponseInterface $response = null
    ) {
        if ( empty( $request ) ) {
            $request = Request::createFromGlobals();
        }

        if ( empty( $response ) ) {
            $response = new Response;
        }

        $this->bootstrapClasses = empty( $bootstrapClasses ) ? $this->getDefaultBootstrapClasses() : $bootstrapClasses;

        $this->slug     = $slug;
        $this->file     = empty( $file ) ? __FILE__ : $file;
        $this->url      = plugin_dir_url( $this->file );
        $this->dir      = plugin_dir_path( $this->file );
        $this->request  = $request;
        $this->response = $response;
        $this->settings = $settings;

        $this->bootstrap();

        do_action( 'wpk.core.loaded', $this );
        do_action( "wpk.core.$this->slug.", $this );
    }

    /**
     * @return array
     */
    private function getDefaultBootstrapClasses(): array
    {
        return [
            ProvidersBootstrap::class,
            MigrationsBootstrap::class,
            CronsBootstrap::class,
            EnqueueBootstrap::class,
            ModulesBootstrap::class,
        ];
    }

    /**
     * @param array $controllers
     *
     * @return void
     */
    public function loadControllers( array $controllers ): void
    {
        foreach ( $controllers as $controller ) {

            $instance = new $controller( $this );
            $this->setupController( $instance );

        }
    }

    /**
     * Setups controller basing on its instance
     *
     * @param Controller $controller
     *
     * @return void
     */
    public function setupController( Controller $controller ): void
    {
        $controller
            ->setRequest( $this->request )
            ->setResponse( $this->response );

        $this->singleton( get_class( $controller ), function () use ( $controller ) {
            return $controller;
        } );
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getUrl( string $path ): string
    {
        $url = $this->url;

        return $url . "{$path}/";
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getPath( string $path ): string
    {
        $dir = $this->dir;

        return $dir . "{$path}/";
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $key
     *
     * @return bool|mixed
     */
    public function getSetting( string $key )
    {
        return $this->settings->get( $key );
    }

    /**
     * @return StorageInterface
     */
    public function getSettings(): StorageInterface
    {
        return $this->settings;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setSetting( string $key, $value )
    {
        return $this->settings->update( $key, $value );
    }

    /**
     * Registers callback that will trigger on plugin activation
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function onActivation( Closure $callback ): void
    {
        register_activation_hook( $this->file, function () use ( $callback ) {
            $callback( $this );
        } );
    }

    /**
     * Registers callback that will trigger on plugin deactivation
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function onDeactivation( Closure $callback ): void
    {
        register_deactivation_hook( $this->file, function () use ( $callback ) {
            $callback( $this );
        } );
    }

    /**
     * Performs bootstrap of application
     *
     * @return App
     */
    protected function bootstrap(): self
    {
        $bootstrapClasses = apply_filters( 'wpk.core.bootstrapClasses', $this->bootstrapClasses );

        foreach ( $bootstrapClasses as $bootstrapClass ) {
            /**
             * @var BaseBootstrap $bootstrap
             */
            $bootstrap = new $bootstrapClass( $this );

            $bootstrap->bootstrap();
        }

        return $this;
    }
}
