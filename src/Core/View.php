<?php

namespace UnderScorer\Core;

use Jenssegers\Blade\Blade;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use UnderScorer\Core\Contracts\ViewRenderInterface;

/**
 * View wrapper class
 *
 * @author Przemysław Żydek
 */
class View implements ViewRenderInterface
{

    /**
     * @var string Path to views directory
     */
    protected $path;

    /**
     * @var string Path to cache directory
     */
    protected $cachePath;

    /**
     * @var Blade Blade instance
     */
    protected $blade;

    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * View constructor.
     *
     * @param Filesystem   $filesystem
     * @param string|array $path Paths to views directory
     * @param string       $cachePath Path to cache directory
     *
     * @throws IOException
     */
    public function __construct( Filesystem $filesystem, string $path, string $cachePath = '' )
    {
        $this->fileSystem = $filesystem;
        $this->path       = $path;

        if ( empty( $cachePath ) ) {
            $this->cachePath = $path . '/cache';
        } else {
            $this->cachePath = $cachePath;
        }

        if ( ! $filesystem->exists( $this->cachePath ) ) {
            $this->createCacheDirectory();
        }

        $this->blade = new Blade( $this->path, $this->cachePath );
    }


    /**
     * @throws IOException
     */
    protected function createCacheDirectory(): void
    {
        $this->fileSystem->mkdir( $this->cachePath, 0777 );
    }

    /**
     * Render view
     *
     * @param string $file
     * @param array  $data
     *
     * @return string
     */
    public function render( string $file, array $data = [] ): string
    {
        return $this->blade->render( $file, $data );
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

}
