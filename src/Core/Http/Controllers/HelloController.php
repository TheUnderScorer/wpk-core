<?php

namespace UnderScorer\Core\Http\Controllers;

use UnderScorer\Core\Http\Controller;

/**
 * Class HelloController
 * @package UnderScorer\Core\Http\Controllers
 */
class HelloController extends Controller
{

    /**
     * Handles request
     *
     * @return void
     */
    public function handle(): void
    {
        $this->response->setContent( [
            'result' => true,
        ] )->json();
    }

}
