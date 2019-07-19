<?php

namespace UnderScorer\Core\Parsers;

/**
 * Interface Parser
 * @package UnderScorer\Core\Parsers
 *
 * This interface describes classes that parse some data into readable format
 */
interface Parser
{

    /**
     * Parses given item
     *
     * @return mixed
     */
    public function parse();

}
