<?php

namespace UnderScorer\Core;

use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Session\Session;
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
     * @param Request           $request
     * @param ResponseInterface $response
     */
    public function __construct(
        string $slug,
        string $file,
        StorageInterface $settings,
        Request $request = null,
        ResponseInterface $response = null
    ) {

        if ( empty( $request ) ) {
            $request = Request::createFromGlobals();

            $request->setSession(
                new Session()
            );
        }

        if ( empty( $response ) ) {
            $response = new Response;
        }

        $this->slug     = $slug;
        $this->file     = empty( $file ) ? __FILE__ : $file;
        $this->url      = plugin_dir_url( $this->file );
        $this->dir      = plugin_dir_path( $this->file );
        $this->request  = $request;
        $this->response = $response;
        $this->settings = $settings;


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
     * @return Settings
     */
    public function getSettings(): Settings
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

}
