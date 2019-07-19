<?php

namespace UnderScorer\Core\Storage;

use DateInterval;
use Illuminate\Contracts\Support\Arrayable;
use Psr\SimpleCache\CacheInterface;
use UnderScorer\Core\Settings;
use UnderScorer\Core\Utility\Arr;

/**
 * Manages custom caching
 *
 * @author Przemysław Żydek
 */
class TransientCache implements CacheInterface, Arrayable
{

    /**
     * @var bool Decides if cache is active or not
     */
    const ENABLED = true;

    /**
     * @var string
     */
    protected $prefix;
    /**
     * @var string
     */
    protected $expiration;
    /**
     * @var string[] Stores transient keys
     */
    protected $transientsKeys = [];

    /**
     * @var StorageInterface
     */
    protected $settings;

    /**
     * Cache constructor.
     *
     * @param string                $prefix Unique cache identifier
     * @param string                $expiration Date parsable by strtotime()
     * @param StorageInterface|null $settings
     */
    public function __construct( string $prefix, string $expiration = '+1 hour', ?StorageInterface $settings = null )
    {
        $this->prefix     = $prefix;
        $this->expiration = $expiration;

        if ( empty( $settings ) ) {
            $settings = new Settings( $prefix );
        }

        $this->settings       = $settings;
        $this->transientsKeys = $this->getTransients();
    }

    /**
     * @return array
     */
    protected function getTransients(): array
    {
        return Arr::make( $this->settings->get( 'cache_transients' ) );
    }

    /**
     * Wipes clean the entire cache's keys.
     *
     * @return bool True on success and false on failure.
     */
    public function clear(): bool
    {

        foreach ( $this->transientsKeys as $key ) {
            $this->delete( $key );
        }

        $this->transientsKeys = [];
        $this->updateTransients();

        return true;

    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string $key The unique cache key of the item to delete.
     *
     * @return bool True if the item was successfully removed. False if there was an error.
     */
    public function delete( $key ): bool
    {

        $uniqueKey = $this->createUniqueKey( $key );

        $this->removeTransientKey( $uniqueKey );

        return (bool) delete_transient( $uniqueKey );
    }

    /**
     * Create unique key for cache value
     *
     * @param string $key
     *
     * @return string
     */
    protected function createUniqueKey( string $key ): string
    {
        return str_replace( [ ' ', '\'', '"', '`', '(', ')', '_', '-' ], [ '' ], $this->prefix . $key );
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    protected function removeTransientKey( string $key ): bool
    {

        foreach ( $this->transientsKeys as $index => $transientKey ) {

            if ( $transientKey === $key ) {
                unset( $this->transientsKeys[ $index ] );
            }

        }

        return $this->updateTransients();

    }

    /**
     * @return bool
     */
    protected function updateTransients(): bool
    {
        return $this->settings->update( 'cache_transients', $this->transientsKeys );
    }

    /**
     * Obtains multiple cache items by their unique keys.
     *
     * @param iterable $keys A list of keys that can obtained in a single operation.
     * @param mixed    $default Default value to return for keys that do not exist.
     *
     * @return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as
     *     value.
     */
    public function getMultiple( $keys, $default = null ): iterable
    {

        $result = [];

        foreach ( $keys as $key ) {
            $result[ $key ] = $this->get( $key, $default );
        }

        return $result;

    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return bool|mixed
     */
    public function get( $key, $default = null )
    {

        if ( ! self::ENABLED ) {
            return $default;
        }

        $uniqueKey = $this->createUniqueKey( $key );
        $value     = maybe_unserialize( get_transient( $uniqueKey ) );

        if ( empty( $value ) ) {
            $this->removeTransientKey( $uniqueKey );

            return $default;
        }

        return $value;

    }

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     *
     * @param iterable              $values A list of key => value pairs for a multiple-set operation.
     * @param null|int|DateInterval $ttl Optional. The TTL value of this item..
     *
     * @return bool True on success and false on failure.
     */
    public function setMultiple( $values, $ttl = null ): bool
    {

        foreach ( $values as $key => $value ) {
            $this->set( $value, $key, $ttl );
        }

        return true;

    }

    /**
     * Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
     *
     * @param string $key The key of the item to store.
     * @param mixed  $value The value of the item to store, must be serializable.
     * @param mixed  $ttl
     *
     * @return bool True on success and false on failure.
     *
     */
    public function set( $key, $value, $ttl = null ): bool
    {

        if ( empty( $expiration ) ) {
            $expiration = $this->getExpiration();
        } else {

            if ( $ttl instanceof DateInterval ) {
                $ttl        = $ttl->m;
                $expiration = strtotime( "+$ttl minutes" ) - time();
            } else {
                $expiration = strtotime( $expiration ) - time();
            }


        }

        if ( ! self::ENABLED || empty( $value ) ) {
            return false;
        }

        $uniqueKey = $this->createUniqueKey( $key );
        $this->addTransientKey( $uniqueKey );

        return set_transient( $uniqueKey, maybe_serialize( $value ), $expiration );

    }

    /**
     * @return int
     */
    protected function getExpiration(): int
    {
        return strtotime( $this->expiration ) - time();
    }

    /**
     * @param string $expiration
     *
     * @return TransientCache
     */
    public function setExpiration( string $expiration ): TransientCache
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    protected function addTransientKey( string $key ): bool
    {
        $this->transientsKeys[] = $key;

        return $this->updateTransients();
    }

    /**
     * Deletes multiple cache items in a single operation.
     *
     * @param iterable $keys A list of string-based keys to be deleted.
     *
     * @return bool True if the items were successfully removed. False if there was an error.
     */
    public function deleteMultiple( $keys ): bool
    {

        foreach ( $keys as $key ) {
            $this->delete( $key );
        }

        return true;
    }

    /**
     * Determines whether an item is present in the cache.
     *
     * @param string $key The cache item key.
     *
     * @return bool
     */
    public function has( $key ): bool
    {
        return ! empty( get_transient( $key ) );
    }

    /**
     * @return string[]
     */
    public function getTransientsKeys(): array
    {
        return $this->transientsKeys;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {

        $result = [];

        foreach ( $this->transientsKeys as $key => $value ) {
            $result[ $key ] = $this->get( $key );
        }

        return $result;

    }

}
