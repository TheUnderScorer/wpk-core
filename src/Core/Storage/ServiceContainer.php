<?php

namespace UnderScorer\Core\Storage;

/**
 * Container for plugin services
 *
 * @author Przemysław Żydek
 */
class ServiceContainer implements StorageInterface
{

    /**
     * @var array Array of service instances
     */
    protected $services = [];

    /**
     * Binds array of instances into container
     *
     * @param array $instances
     *
     * @return static
     */
    public function addMany( array $instances )
    {

        foreach ( $instances as $index => $instance ) {

            $key = is_numeric( $index ) || empty( $index ) ? get_class( $instance ) : $index;

            $this->add( $instance, $key );

        }

        return $this;

    }

    /**
     * Binds new instance into container
     *
     * @param mixed  $instance
     * @param string $key If empty class name is used instead
     *
     * @return static
     */
    public function add( $instance, string $key = '' )
    {

        if ( empty( $key ) ) {
            $key = get_class( $instance );
        }

        $this->services[ $key ] = $instance;

        return $this;

    }

    /**
     * Remove service from container
     *
     * @param string $key
     *
     * @return static
     */
    public function remove( string $key )
    {
        unset( $this->services[ $key ] );

        return $this;
    }

    /**
     * Get stored service instance, or false if it doesn't exists
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get( string $key )
    {
        return $this->services[ $key ] ?? false;
    }

    /**
     * Check if provided service exists in container
     *
     * @param string $key
     *
     * @return bool
     */
    public function has( string $key ): bool
    {
        return array_key_exists( $key, $this->services );
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
    public function count(): int
    {
        return count( $this->services );
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode( $this->toArray() );
    }

    /**
     * Returns services array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->services;
    }

    /**
     * Updates value in provided item
     *
     * @param string $key
     * @param mixed  $instance
     *
     * @return self
     */
    public function update( string $key, $instance ): self
    {
        return $this->add( $instance, $key );
    }

}
