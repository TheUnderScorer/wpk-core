<?php

namespace UnderScorer\Core\Tests\Mock\Http;

use UnderScorer\Core\Http\ResponseInterface;
use UnderScorer\Core\Http\ResponseTemplates\ResponseContentInterface;

/**
 * Class MockResponse
 * @package UnderScorer\Core\Tests\Mock\Http
 */
class MockResponse implements ResponseInterface
{

    /**
     * @var array
     */
    protected $sentResponses = [];

    /**
     * @var array
     */
    protected $renderedResponses = [];

    /**
     * @var array
     */
    protected $redirects = [];

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
     * @param ResponseContentInterface $response
     *
     * @return void
     */
    public function send( ResponseContentInterface $response ): void
    {
        $this->sentResponses[] = $response;
    }

    /**
     * @param string $view
     */
    public function render( string $view ): void
    {
        $this->renderedResponses[] = $view;
    }

    /**
     * Redirects user to provided url
     *
     * @return void
     */
    public function redirect(): void
    {
        $this->redirects[] = $this->redirectUrl;
    }

    /**
     * Set redirect url
     *
     * @param string $url
     *
     * @return static
     */
    public function setRedirectUrl( string $url )
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
     * @return static
     */
    public function setCode( int $code )
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return array
     */
    public function getSentResponses(): array
    {
        return $this->sentResponses;
    }

    /**
     * @return array
     */
    public function getRenderedResponses(): array
    {
        return $this->renderedResponses;
    }

    /**
     * @return array
     */
    public function getRedirects(): array
    {
        return $this->redirects;
    }

}
