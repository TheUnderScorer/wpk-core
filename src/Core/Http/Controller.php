<?php

namespace UnderScorer\Core\Http;

use UnderScorer\Core\BaseController;
use UnderScorer\Core\Contracts\NextContract;

/**
 * Class Controller
 * @package UnderScorer\Core\Http
 */
abstract class Controller extends BaseController implements NextContract
{

    /**
     * @return void
     */
    public function next(): void
    {
        $this->handle();
    }

    /**
     * Handles request
     *
     * @return void
     */
    abstract public function handle();

    /**
     * @inheritDoc
     */
    protected function setup(): void
    {

    }

}
