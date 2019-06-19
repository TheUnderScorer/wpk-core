<?php

namespace UnderScorer\Core\Hooks\Middleware;

use UnderScorer\Core\Http\ResponseTemplates\ErrorResponse;

/**
 * Middleware for validating required fields in request
 *
 * @author Przemysław Żydek
 */
class FieldsValidator extends HttpMiddleware
{

    /**
     * @param string $source Source in which validation will be performed. Options are: body, query, cookie
     * @param array  $requiredFields
     * @param bool   $onlyIsset
     *
     * @return void
     */
    public function handle( string $source = 'body', array $requiredFields = [], bool $onlyIsset = false ): void
    {

        $hasError = false;

        $errorResponse = new ErrorResponse();

        foreach ( $requiredFields as $field ) {

            if ( ! $this->checkValue( $source, $field, $onlyIsset ) ) {
                $errorResponse->addMessage(
                    sprintf( esc_html__( '%s is required.', 'wpk' ), $field ),
                    'REQUIRED_FIELD_EMPTY'
                );

                $hasError = true;
            }

        }

        if ( $hasError ) {
            $this->response->send( $errorResponse );
        }

    }

    /**
     * @param string $source
     * @param string $key
     * @param bool   $onlyIsset
     *
     * @return bool
     */
    protected function checkValue( string $source, string $key, bool $onlyIsset ): bool
    {
        $request = $this->request;

        switch ( $source ) {

            case 'query':
                return $onlyIsset ? $request->query->has( $key ) : ! empty( $request->query->get( $key ) );

            case 'cookie':
                return $onlyIsset ? $request->cookies->has( $key ) : ! empty( $request->cookies->get( $key ) );

            default:
                return $onlyIsset ? $request->request->has( $key ) : ! empty( $request->request->get( $key ) );

        }
    }

}
