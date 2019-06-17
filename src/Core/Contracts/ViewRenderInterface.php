<?php

namespace UnderScorer\Core\Contracts;

/**
 * Interface that manages view rendering
 *
 * @package UnderScorer\Core\Contracts
 */
interface ViewRenderInterface
{

    /**
     * Renders view
     *
     * @param string $file
     * @param array  $data
     *
     * @return string
     */
    public function render( string $file, array $data = [] ): string;

}
