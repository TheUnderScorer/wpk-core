<?php


namespace UnderScorer\Core\Http\Contracts;

/**
 * Interface KernelInterface
 * @package UnderScorer\Core\Http\Contracts
 */
interface KernelInterface
{

    /**
     * Bootstraps kernel
     *
     * @return void
     */
    public function bootstrap(): void;

}
