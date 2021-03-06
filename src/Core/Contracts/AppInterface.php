<?php

namespace UnderScorer\Core\Contracts;

use ArrayAccess;
use Closure;
use Illuminate\Contracts\Container\Container;
use UnderScorer\Core\Hooks\Controllers\Controller;
use UnderScorer\Core\Http\Request;
use UnderScorer\Core\Http\ResponseInterface;
use UnderScorer\Core\Lifecycle\Activable;
use UnderScorer\Core\Storage\StorageInterface;

/**
 * Interface AppInterface
 * @package UnderScorer\Core\Contracts
 */
interface AppInterface extends Container, ArrayAccess, Activable
{

    /**
     * @param array $controllers
     *
     * @return void
     */
    public function loadControllers( array $controllers ): void;

    /**
     * Setups controller basing on its instance
     *
     * @param Controller $controller
     *
     * @return void
     */
    public function setupController( Controller $controller ): void;

    /**
     * @param string $path
     *
     * @return string
     */
    public function getUrl( string $path ): string;

    /**
     * @param string $path
     *
     * @return string
     */
    public function getPath( string $path ): string;

    /**
     * @return string
     */
    public function getSlug(): string;

    /**
     * @return string
     */
    public function getFile(): string;

    /**
     * @param string $key
     *
     * @return bool|mixed
     */
    public function getSetting( string $key );

    /**
     * @return StorageInterface
     */
    public function getSettings(): StorageInterface;

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setSetting( string $key, $value );

    /**
     * Registers callback that will trigger on plugin activation
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function onActivation( Closure $callback ): void;

    /**
     * Registers callback that will trigger on plugin deactivation
     *
     * @param Closure $callback
     *
     * @return void
     */
    public function onDeactivation( Closure $callback ): void;

    /**
     * @return Request
     */
    public function getRequest(): Request;

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;

}
