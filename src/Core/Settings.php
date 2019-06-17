<?php

namespace UnderScorer\Core;

use UnderScorer\Core\Storage\StorageInterface;

/**
 * Manages settings using ACF plugin
 *
 * @author Przemysław Żydek
 */
class Settings implements StorageInterface
{

    /**
     * @var string
     */
    protected $prefix = '';

    /**
     * Settings constructor.
     *
     * @param string $prefix
     */
    public function __construct( string $prefix )
    {
        $this->prefix = $prefix;
    }

    /**
     * Get setting via its key
     *
     * @param string|int $key
     *
     * @return bool|mixed
     */
    public function get( string $key )
    {

        $value = $this->getField( $key );

        return apply_filters( 'wpk/settings/get', $value, $key );

    }

    /**
     * Helper function for accessing fields in options
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    protected function getField( $key, $default = null )
    {

        $prefix = $this->prefix;

        return get_option( $prefix . $key, $default );

    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [];
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return 0;
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return '';
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has( string $key ): bool
    {
        return ! empty( $this->getField( $key ) );
    }

    /**
     * @param array $items
     *
     * @return static
     */
    public function addMany( array $items )
    {

        foreach ( $items as $key => $item ) {
            $this->add( $item, $key );
        }

        return $this;

    }

    /**
     * @param mixed  $value
     * @param string $key
     *
     * @return bool
     */
    public function add( $value, string $key = '' ): bool
    {
        return $this->updateField( $key, $value );
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @return bool
     */
    protected function updateField( $key, $value ): bool
    {

        $prefix = $this->prefix;

        return update_option( $prefix . $key, $value );

    }

    /**
     * @param string $key
     *
     * @return static
     */
    public function remove( string $key )
    {
        $this->removeField( $key );

        return $this;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    protected function removeField( string $key ): bool
    {

        $prefix = $this->prefix;

        return delete_option( $prefix . $key );

    }

    /**
     * Updates value in provided item
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function update( string $key, $value )
    {
        return $this->updateField( $key, $value );
    }

}
