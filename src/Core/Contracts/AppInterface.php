<?php

namespace UnderScorer\Core\Contracts;

use UnderScorer\Core\Hooks\Controllers\Controller;
use UnderScorer\Core\Settings;
use UnderScorer\Core\Storage\StorageInterface;

/**
 * Interface AppInterface
 * @package UnderScorer\Core\Contracts
 */
interface AppInterface
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
     * @return StorageInterface
     */
    public function getContainer(): StorageInterface;

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
     * @return Settings
     */
    public function getSettings(): Settings;

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setSetting( string $key, $value );

}
