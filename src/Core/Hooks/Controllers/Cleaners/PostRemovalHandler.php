<?php

namespace UnderScorer\Core\Hooks\Controllers\Cleaners;

use UnderScorer\Core\Cron\Cleaners\PostCleaner;
use UnderScorer\Core\Hooks\Controllers\Cron\CronController;
use UnderScorer\Core\Utility\Logger;

/**
 * @author Przemysław Żydek
 */
class PostRemovalHandler extends CronController
{

    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setup();

        PostCleaner::setCron( $this->cron );
    }

    /**
     * @param int $postID
     *
     * @return void
     */
    public function handle( int $postID = 0 ): void
    {

        if ( ! $postID ) {
            return;
        }

        Logger::log( "Attempting to remove post with id $postID", __METHOD__ );

        $result = wp_delete_post( $postID, true );

        if ( $result ) {
            $message = 'Successfuly removed post.';
        } else {
            $message = 'Post could not be removed.';
        }

        Logger::log( $message, __METHOD__ );

    }

}
