<?php

namespace UnderScorer\Core\Http;

use UnderScorer\Core\Http\ResponseTemplates\ResponseTemplateInterface;

/**
 * @author Przemysław Żydek
 */
class Response
{

    /**
     * @var int
     */
    protected $code = 200;

    /**
     * @var string
     */
    protected $redirectUrl = '';

    /**
     * Sends json with provided response template
     *
     * @param ResponseTemplateInterface $response
     *
     * @return void
     */
    public function send( ResponseTemplateInterface $response )
    {
        wp_send_json( $response->toArray(), $this->code );
    }

    /**
     * @param string $view
     */
    public function render( string $view ): void
    {
        echo $view;

        die();
    }

    /**
     * Redirects user to provided url
     *
     * @return void
     */
    public function redirect()
    {
        wp_redirect( $this->redirectUrl, $this->code );

        die();
    }

    /**
     * Set redirect url
     *
     * @param string $url
     *
     * @return self
     */
    public function setRedirectUrl( string $url ): self
    {
        $this->redirectUrl = $url;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     *
     * @return Response
     */
    public function setCode( int $code ): self
    {
        $this->code = $code;

        return $this;
    }

}
