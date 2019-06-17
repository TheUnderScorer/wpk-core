<?php

namespace UnderScorer\Core\Storage;

/**
 * Storage class that contains array of json converted arrays
 *
 * @author Przemysław Żydek
 */
class JsonStore implements StorageInterface
{

    /** @var array */
    protected $store = [];

    /**
     * JsonStore constructor.
     *
     * @param mixed $data
     */
    public function __construct( array $data = [] )
    {
        $this->store = $data;
    }

    /**
     * @param array $data
     *
     * @return JsonStore
     */
    public static function makeFromArray( array $data )
    {
        $data = array_map( 'json_encode', $data );

        return new static( $data );
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     *
     * @return int The custom count as an integer.
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count(): int
    {
        return count( $this->store );
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode( $this->store );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getStore();
    }

    /**
     * @return array
     */
    public function getStore(): array
    {
        return $this->store;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get( string $key )
    {
        return $this->store[ $key ] ?? false;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has( string $key ): bool
    {
        return isset( $this->store[ $key ] );
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
     * Append data to store
     *
     * @param array  $data
     * @param string $key
     *
     * @return $this
     */
    public function add( $data, string $key = '' )
    {
        $this->store[ $key ] = json_encode( $data );

        return $this;
    }

    /**
     * @param string $key
     *
     * @return static
     */
    public function remove( string $key )
    {
        unset( $this->store[ $key ] );

        return $this;
    }

}
