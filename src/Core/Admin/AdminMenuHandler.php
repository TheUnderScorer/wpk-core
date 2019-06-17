<?php

namespace UnderScorer\Core\Admin;

/**
 * @author Przemysław Żydek
 */
interface AdminMenuHandler
{

    /**
     * Renders admin menu
     *
     * @return void
     */
    public function menu(): void;

}
