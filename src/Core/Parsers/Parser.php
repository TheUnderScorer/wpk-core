<?php

namespace UnderScorer\Core\Parsers;

interface Parser
{

    /**
     * @param mixed $item
     *
     * @return mixed
     */
    public static function parse( $item );

}
