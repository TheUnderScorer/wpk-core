<?php

namespace UnderScorer\Core\Http;

use UnderScorer\Core\Http\ResponseTemplates\ResponseTemplateInterface;

interface ResponseInterface
{

    /**
     * Sends json with provided response template
     *
     * @param ResponseTemplateInterface $response
     *
     * @return void
     */
    public function send( ResponseTemplateInterface $response ): void;

    /**
     * @param string $view
     */
    public function render( string $view ): void;

    /**
     * Redirects user to provided url
     *
     * @return void
     */
    public function redirect(): void;

    /**
     * Set redirect url
     *
     * @param string $url
     *
     * @return static
     */
    public function setRedirectUrl( string $url );

    /**
     * @return int
     */
    public function getCode(): int;

    /**
     * @param int $code
     *
     * @return static
     */
    public function setCode( int $code );


}
