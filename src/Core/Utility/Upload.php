<?php

namespace UnderScorer\Core\Utility;

use Exception;
use UnderScorer\Core\Exceptions\WPErrorException;


/**
 * Class Upload
 * @package UnderScorer\Core\Utility
 */
class Upload
{

    /**
     * Create attachment from uploaded file
     *
     * @param array $file
     *
     * @return int
     *
     * @throws Exception
     */
    public static function createAttachment( array $file ): int
    {

        $upload = wp_handle_upload( $file, [ 'test_form' => false ] );

        if ( isset( $upload[ 'error' ] ) ) {
            throw new Exception( 'Invalid file provided.' );
        }

        $attachment = [
            'post_mime_type' => $upload[ 'type' ],
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload[ 'url' ] ) ),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'guid'           => $upload[ 'url' ],
        ];

        $attachID = wp_insert_attachment( $attachment, $upload[ 'file' ] );

        if ( is_wp_error( $attachID ) ) {
            throw new WPErrorException( $attachID );
        }

        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        $attachmentData = wp_generate_attachment_metadata( $attachID, $upload[ 'file' ] );

        wp_update_attachment_metadata( $attachID, $attachmentData );

        return $attachID;

    }

}
