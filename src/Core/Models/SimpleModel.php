<?php

namespace UnderScorer\Core\Models;

use Countable;
use Illuminate\Contracts\Support\Arrayable;
use UnderScorer\Core\Exports\Jsonable;

/**
 * @author Przemysław Żydek
 */
class SimpleModel implements Arrayable, Countable, Jsonable
{

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
        return count( $this->toArray() );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars( $this );
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode( $this->toArray() );
    }

}
