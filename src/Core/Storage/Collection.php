<?php

namespace UnderScorer\Core\Storage;

use Illuminate\Support\Collection as BaseCollection;

/**
 * @author Przemysław Żydek
 */
class Collection extends BaseCollection
{

    /** @var array */
    protected $items = [];

    /**
     * @var int Stores total items count
     */
    protected $count;

    /**
     * Collection constructor.
     *
     * @param mixed $items
     */
    public function __construct( $items = [] )
    {
        parent::__construct( $items );

        $this->count = count( $this->items );
    }

    /**
     * Add new items to collection
     *
     * @param mixed|Collection $items
     * @param string|null      $key
     *
     * @return Collection
     */
    public function add( $items, string $key = null ): self
    {

        if ( $items instanceof self ) {
            $this->items = array_merge( $items->all(), $this->all() );
        } else if ( is_array( $items ) ) {
            $this->items = array_merge( $this->getArrayableItems( $items ), $this->items );
        } else {

            if ( $key ) {
                $this->items[ $key ] = $items;
            } else {
                $this->items[] = $items;
            }
        }

        return $this;

    }

    /**
     * @return bool
     */
    public function empty()
    {
        return empty( $this->items );
    }

    /**
     * @param      $key
     * @param      $value
     * @param bool $strict
     *
     * @return static
     */
    public function find( $key, $value, bool $strict = false ): self
    {

        $results = [];

        foreach ( $this->all() as $item ) {

            $itemObj = (object) $item;

            if ( $strict && $itemObj->$key === $value ) {
                $results[] = $item;
            } else if ( $itemObj->$key == $value ) {
                $results[] = $item;
            }

        }

        return new static( $results );

    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->count === 0 ? count( $this->items ) : $this->count;
    }

    /**
     * @param int $count
     *
     * @return Collection
     */
    public function setCount( int $count ): Collection
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return (array) $this->items;
    }

}
