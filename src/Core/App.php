<?php

namespace UnderScorer\Core;

use UnderScorer\Core\Contracts\AppInterface;
use UnderScorer\Core\Hooks\Controllers\Controller;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\Response;
use UnderScorer\Core\Storage\StorageInterface;

/**
 * Core project class
 *
 * @author Przemysław Żydek
 */
class App implements AppInterface
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
    protected $container;

    /**
     * @var string Stores path to this plugin directory
     */
    protected $dir;

    /**
     * @var string Stores url to this plugin directory
     */
    protected $url;


    /**
     * Core constructor
     *
     * @param string           $slug Plugin slug
     * @param string           $file Main plugin file
     * @param StorageInterface $container Container for modules
     * @param Settings         $settings Settings instance
     * @param string[]         $controllers Array of controllers references that will be loaded
     */
    public function __construct(
        string $slug,
        string $file,
        StorageInterface $container,
        Settings $settings,
        array $controllers = []
    ) {

        $this->slug      = $slug;
        $this->file      = empty( $file ) ? __FILE__ : $file;
        $this->url       = plugin_dir_url( $this->file );
        $this->dir       = plugin_dir_path( $this->file );
        $this->container = $container;

        $this->container->add( $settings, 'settings' );

        if ( ! empty( $controllers ) ) {
            $this->loadControllers( $controllers );
        }

        do_action( 'wpk/core/loaded', $this );
        do_action( "wpk/core/$this->slug/loaded", $this );

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

        static $request = null;
        static $response = null;

        if ( empty( $request ) ) {
            $request = Request::createFromGlobals();
        }

        if ( empty( $response ) ) {
            $response = new Response;
        }

        $controller
            ->setRequest( $request )
            ->setResponse( $response );

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
     * @return StorageInterface
     */
    public function getContainer(): StorageInterface
    {
        return $this->container;
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
        return $this->getSettings()->get( $key );
    }

    /**
     * @return Settings
     */
    public function getSettings(): Settings
    {
        return $this->container->get( 'settings' );
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setSetting( string $key, $value )
    {
        return $this->getSettings()->update( $key, $value );
    }

}
