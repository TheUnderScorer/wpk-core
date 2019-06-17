<?php

namespace UnderScorer\Core\Exports;

/**
 * Converts object to json
 */
interface Jsonable
{

    /**
     * @return string
     */
    public function toJson(): string;

}
