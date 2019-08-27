<?php

namespace UnderScorer\Core\Http\Contracts;

/**
 * Interface RequestHandler
 * @package UnderScorer\Core\Http\Contracts
 */
interface RequestHandler
{

    /**
     * Handles request using given args.
     *
     * @return void
     */
    public function handle(): void;

}
