<?php

namespace UnderScorer\Core\Http;

use UnderScorer\Core\BaseController;

/**
 * Class Controller
 * @package UnderScorer\Core\Http
 */
abstract class Controller extends BaseController
{

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
