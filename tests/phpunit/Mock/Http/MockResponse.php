<?php

namespace UnderScorer\Core\Tests\Mock\Http;

use UnderScorer\Core\Http\Response;

/**
 * Class MockResponse
 * @package UnderScorer\Core\Tests\Mock\Http
 */
class MockResponse extends Response
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
     * @inheritDoc
     */
    public function send(): void
    {
        $this->sentResponses[] = $this->content;
    }

    /**
     * @inheritDoc
     */
    public function json(): void
    {
        $this->sentResponses[] = $this->content;
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
     * @param string $url
     *
     * @return void
     */
    public function redirect( string $url ): void
    {
        $this->redirects[] = $url;
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
