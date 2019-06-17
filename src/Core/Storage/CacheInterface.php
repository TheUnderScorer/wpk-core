<?php

namespace UnderScorer\Core\Storage;

/**
 * @author Przemysław Żydek
 */
interface CacheInterface extends StorageInterface
{

    /**
     * Adds new item into cache
     *
     * @param mixed  $item
     * @param string $key
     * @param string $expiration
     *
     * @return bool
     */
    public function add( $item, string $key = '', string $expiration = '' ): bool;

    /**
     * @param array  $items
     * @param string $expiration
     *
     * @return bool
     */
    public function addMany( array $items, string $expiration = '' ): bool;

}
