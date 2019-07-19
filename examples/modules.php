<?php

use UnderScorer\Core\Exceptions\RequestException;
use UnderScorer\Core\Hooks\Controllers\AjaxController;
use UnderScorer\Core\Hooks\Controllers\Controller;
use UnderScorer\Core\Hooks\Middleware\ValidationMiddleware;
use UnderScorer\Core\Module;

/**
 * Class ExampleModule
 */
class ExampleModule extends Module
{

    /**
     * @var array Stores controllers related to this module
     */
    protected $controllers = [
        ExampleController::class,
    ];

    /**
     * Performs module bootstrap
     *
     * @return void
     */
    protected function bootstrap(): void
    {
        $menu  = $this->menu;
        $title = esc_html__( 'Example module menu', 'example' );

        // Configures module menu
        $menu
            ->setMenuTitle( $title )
            ->setPageTitle( $title )
            ->setCallback( function () {
                do_action( 'wpk/exampleModule/menu' );
            } );
    }

}

/**
 * Class ExampleController
 */
class ExampleController extends Controller
{

    /**
     * @return void
     */
    public function handle(): void
    {
        echo 'Hello World!';
    }

    /**
     * Performs controller setup
     *
     * @return void
     */
    protected function setup(): void
    {
        add_action( 'init', [ $this, 'handle' ] );
    }
}

/**
 * Class ExampleAjaxController
 */
class ExampleAjaxController extends AjaxController
{

    /**
     * @var string
     */
    protected $hook = 'wpk/exampleAjaxHook';

    /**
     * @var bool
     */
    protected $public = true;

    /**
     * @var array
     */
    protected $validationRules = [
        'foo' => 'numeric|required',
    ];

    /**
     * @var array
     */
    protected $middleware = [
        'validator' => ValidationMiddleware::class,
    ];

    /**
     * @return void
     * @throws RequestException
     */
    public function handle(): void
    {

        // You can throw exceptions inside ajax controller, the error message will be send in response
        if ( $this->request->query->has( 'action' ) ) {
            throw new RequestException( 'Missing "action" parameter in query!' );
        }

        /**
         * @see ValidationMiddleware::handle() for parameters
         */
        $this->middleware( 'validator', $this->request->request->all(), $this->validationRules );

        $data = [
            'bar' => $this->request->request->get( 'foo' ),
        ];

        // Sends response in json format
        $this->response->setContent( $data )->json();
    }

}
