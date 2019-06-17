<?php

namespace UnderScorer\Core\Hooks\Controllers\Http;

use UnderScorer\Core\Hooks\Controllers\HttpController;
use UnderScorer\Core\Http\ResponseTemplates\BaseResponse;

/**
 * @author Przemysław Żydek
 */
class GetCoreVersionHandler extends HttpController
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

        $response         = new BaseResponse();
        $response->result = CORE_VERSION;

        $this->response->send( $response );

    }

}
