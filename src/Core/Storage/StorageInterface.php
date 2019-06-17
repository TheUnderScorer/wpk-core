<?php

namespace UnderScorer\Core\Storage;

use Countable;
use Illuminate\Contracts\Support\Arrayable;
use UnderScorer\Core\Exports\Jsonable;

/**
 * @author Przemysław Żydek
 */
interface StorageInterface extends Arrayable, Countable, Jsonable
{

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get( string $key );

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has( string $key ): bool;

    /**
     * @param mixed  $item
     * @param string $key
     *
     * @return static
     */
    public function add( $item, string $key = '' );

    /**
     * @param array $items
     *
     * @return static
     */
    public function addMany( array $items );

    /**
     * @param string $key
     *
     * @return static
     */
    public function remove( string $key );

    /**
     * Updates value in provided item
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function update( string $key, $value );

}
