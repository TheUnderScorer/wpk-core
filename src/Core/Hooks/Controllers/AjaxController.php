<?php

namespace UnderScorer\Core\Hooks\Controllers;


use Rakit\Validation\ErrorBag;
use UnderScorer\Core\Exceptions\Exception;
use UnderScorer\Core\Exceptions\RequestException;
use UnderScorer\Core\Exceptions\ValidationException;
use UnderScorer\Core\Http\ResponseTemplates\ErrorResponseContent;

/**
 * Class AjaxController
 * @package UnderScorer\Core\Hooks\Controllers
 *
 * This class handles ajax requests called by wp_ajax hook
 */
abstract class AjaxController extends Controller
{

    /**
     * @var string
     */
    protected $hook = '';

    /**
     * @var bool Determines whenever this action is public or not (public is accessable by not logged in users)
     */
    protected $public = false;

    /**
     * Handles actual request
     *
     * @return void
     */
    final public function handleRequest(): void
    {
        $response = $this->response;
        $error    = new ErrorResponseContent();

        try {
            $this->handle();
        } catch ( RequestException $e ) {
            $error->addMessage( $e->getMessage() );
            $error->setCode( $e->getStatusCode() );
        } catch ( ValidationException $e ) {
            $this->parseValidationException( $error, $e );
        } catch ( Exception $e ) {
            $this->parseException( $error, $e );
        }

        $response->setContent( $error )->json();
    }

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * @param ErrorResponseContent $error
     * @param ValidationException  $exception
     */
    private function parseValidationException( ErrorResponseContent $error, ValidationException $exception ): void
    {
        /**
         * @var ErrorBag $errorBag
         */
        foreach ( $exception->getErrors() as $errorBag ) {
            foreach ( $errorBag->all() as $errorMessage ) {
                $error->addMessage( $errorMessage, 'INVALID_FIELD' );
            }
        }
    }

    /**
     * @param ErrorResponseContent $error
     * @param Exception            $exception
     */
    private function parseException( ErrorResponseContent $error, Exception $exception ): void
    {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            $error->addMessage( $exception->getMessage() );
        } else {
            $error->addMessage(
                esc_html__( 'Internal server error.' )
            );
        }
    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    final protected function setup(): void
    {
        add_action( "wp_ajax_$this->hook", [ $this, 'handleRequest' ] );

        if ( $this->public ) {
            add_action( "wp_ajax_nopriv_$this->hook", [ $this, 'handleRequest' ] );
        }
    }

}
