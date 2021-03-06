<?php

namespace UnderScorer\Core\Http;

use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @author Przemysław Żydek
 */
class Response extends BaseResponse implements ResponseInterface
{

    /**
     * @inheritDoc
     */
    public function json(): void
    {
        $content = is_string( $this->content ) ? json_decode( $this->content ) : $this->content;

        $this->sendHeaders();

        wp_send_json( $content, $this->statusCode );
    }

    /**
     * @return mixed|BaseResponse|void
     */
    public function send()
    {
        parent::send();

        die();
    }

    /**
     * @param mixed $content
     *
     * @return BaseResponse
     */
    public function setContent( $content )
    {
        if ( $content instanceof Arrayable ) {
            $content = $content->toArray();
        }

        if ( is_array( $content ) || is_object( $content ) ) {
            $content = json_encode( $content );
        }

        return parent::setContent( $content );
    }

    /**
     * @inheritDoc
     */
    public function redirect( string $url )
    {
        wp_safe_redirect( $url, $this->statusCode ? $this->statusCode : self::HTTP_TEMPORARY_REDIRECT );

        die();
    }

    /**
     * @return ResponseHeaderBag
     */
    public function headers(): ResponseHeaderBag
    {
        return $this->headers;
    }

}
