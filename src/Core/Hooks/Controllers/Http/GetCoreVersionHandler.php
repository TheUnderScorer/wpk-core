<?php

namespace UnderScorer\Core\Hooks\Controllers\Http;

use UnderScorer\Core\Exceptions\RequestException;
use UnderScorer\Core\Hooks\Controllers\AjaxController;
use UnderScorer\Core\Http\ResponseTemplates\ResponseContent;

/**
 * @author Przemysław Żydek
 */
class GetCoreVersionHandler extends AjaxController
{

    /**
     * @var string
     */
    protected $hook = 'core/getVersion';

    /**
     * @var bool
     */
    protected $public = true;

    /**
     * @inheritDoc
     */
    public function handle(): void
    {
        $response         = new ResponseContent();
        $response->result = CORE_VERSION;

        $this->response->setContent( $response )->json();
    }

}
