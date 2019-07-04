<?php

namespace UnderScorer\Core\Http;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

interface ResponseInterface
{

    /**
     * Sends response
     *
     * @return mixed
     */
    public function send();

    /**
     * Sends response as json
     *
     * @return mixed
     */
    public function json();

    /**
     * Redirects user to provided url
     *
     * @param string $url
     *
     * @return mixed
     */
    public function redirect( string $url );

    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @param int $code
     *
     * @return static
     */
    public function setStatusCode( int $code );

    /**
     * @return ResponseHeaderBag
     */
    public function headers(): ResponseHeaderBag;

    /**
     * Sets response content
     *
     * @param mixed $content
     *
     * @return static
     */
    public function setContent( $content );

    /**
     * Returns response content
     *
     * @return mixed
     */
    public function getContent();

}
