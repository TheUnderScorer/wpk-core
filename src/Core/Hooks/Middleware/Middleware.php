<?php

namespace UnderScorer\Core\Hooks\Middleware;

/**
 * @author Przemysław Żydek
 */
interface Middleware
{

    /**
     * @param array $params Optional parameters
     *
     * @return void
     */
    public function handle( array $params = [] );

}
