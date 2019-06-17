<?php

namespace UnderScorer\Core\Models;

use Countable;
use Illuminate\Contracts\Support\Arrayable;
use UnderScorer\Core\Exports\Jsonable;

/**
 * @author Przemysław Żydek
 */
interface ModelInterface extends Countable, Arrayable, Jsonable
{

    /**
     * @return int|string
     */
    public function getID();

    /**
     * Updates model
     *
     * @return bool
     */
    public function update(): bool;

    /**
     * Saves model
     *
     * @return bool
     */
    public function save(): bool;

    /**
     * Deletes model
     *
     * @return bool
     */
    public function delete(): bool;

}
