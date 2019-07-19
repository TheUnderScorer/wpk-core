<?php

namespace UnderScorer\Core\Hooks\Controllers;


use Rakit\Validation\ErrorBag;
use UnderScorer\Core\Exceptions\Exception;
use UnderScorer\Core\Exceptions\RequestException;
use UnderScorer\Core\Exceptions\ValidationException;
use UnderScorer\Core\Http\ResponseTemplates\ErrorResponse;

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
        $response      = $this->response;
        $errorResponse = new ErrorResponse();

        try {
            $this->handle();
        } catch ( RequestException $e ) {
            $errorResponse->addMessage( $e->getMessage() );
            $errorResponse->setCode( $e->getStatusCode() );
        } catch ( ValidationException $e ) {

            /**
             * @var ErrorBag $error
             */
            foreach ( $e->getErrors() as $error ) {
                foreach ( $error->all() as $errorMessage ) {
                    $errorResponse->addMessage( $errorMessage, 'INVALID_FIELD' );
                }
            }

        } catch ( Exception $e ) {

            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                $errorResponse->addMessage( $e->getMessage() );
            } else {
                $errorResponse->addMessage(
                    esc_html__( 'Internal server error.' )
                );
            }

        }

        $response->setContent( $errorResponse )->json();
    }

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * Performs controller setup
     *
     * @return void
     */
    protected function setup(): void
    {
        add_action( "wp_ajax_$this->hook", [ $this, 'handleRequest' ] );

        if ( $this->public ) {
            add_action( "wp_ajax_nopriv_$this->hook", [ $this, 'handleRequest' ] );
        }
    }

}
