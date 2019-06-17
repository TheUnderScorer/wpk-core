<?php

namespace UnderScorer\Core\Hooks\Middleware;

use function UnderScorer\Core\request;
use function UnderScorer\Core\response;

/**
 * Middleware for validating required fields in request
 *
 * @author Przemysław Żydek
 */
class RequiredFieldsValidator implements Middleware
{

    /**
     * @param array $params Optional parameters
     *
     * @return void
     */
    public function handle( array $params = [] )
    {

        $requiredFields = $params[ 0 ];
        $onlyIsset      = $params[ 1 ] ?? false;

        $response = response();
        $request  = request();

        $hasError = false;

        foreach ( $requiredFields as $field ) {

            if ( ! $onlyIsset ) {
                if ( empty( $request->post( $field ) ) ) {

                    $response->addError(
                        sprintf( esc_html__( '%s is required.', 'wpk' ), $field ),
                        'REQUIRED_FIELD_EMPTY'
                    );

                    $hasError = true;

                }
            } else {
                if ( ! $request->request->has( $field ) ) {

                    $response->addError(
                        sprintf( esc_html__( '%s is required.', 'wpk' ), $field ),
                        'REQUIRED_FIELD_EMPTY'
                    );

                    $hasError = true;

                }
            }

        }

        if ( $hasError ) {
            $response->sendJson();
        }

    }
}
