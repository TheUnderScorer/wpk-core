<?php

namespace UnderScorer\Core\Http;

use Symfony\Component\HttpFoundation\Request as BaseRequest;

/**
 * @author Przemysław Żydek
 */
class Request extends BaseRequest
{

    /**
     * @param string $action
     * @param string $queryParam
     *
     * @return bool
     */
    public function checkNonce( string $action, string $queryParam ): bool
    {
        return (bool) check_ajax_referer( $action, $queryParam, false );
    }

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return wp_doing_ajax() ||
               isset( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) &&
               strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) === 'xmlhttprequest';
    }

}

