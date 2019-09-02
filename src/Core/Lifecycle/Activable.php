<?php

namespace UnderScorer\Core\Lifecycle;

use Closure;

/**
 * Interface Activable
 * @package UnderScorer\Core\Lifecycle
 */
interface Activable
{

    /**
     * @param Closure $callback
     *
     * @return mixed
     */
    public function onActivation( Closure $callback );

    /**
     * @param Closure $callback
     *
     * @return mixed
     */
    public function onDeactivation( Closure $callback );

}
