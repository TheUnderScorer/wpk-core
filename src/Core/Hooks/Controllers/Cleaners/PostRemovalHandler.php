<?php

namespace UnderScorer\Core\Hooks\Controllers\Cleaners;

use Illuminate\Contracts\Container\BindingResolutionException;
use Psr\Log\LoggerInterface;
use UnderScorer\Core\Cron\Cleaners\PostCleaner;
use UnderScorer\Core\Hooks\Controllers\Cron\CronController;

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
     * @throws BindingResolutionException
     */
    public function handle( int $postID = 0 ): void
    {
        /**
         * @var LoggerInterface $logger
         */
        $logger = $this->app->make( LoggerInterface::class );

        if ( ! $postID ) {
            return;
        }

        $logger->notice( "Attempting to remove post with id $postID", [ __METHOD__ ] );

        $result = wp_delete_post( $postID, true );

        if ( $result ) {
            $message = 'Successfuly removed post.';
        } else {
            $message = 'Post could not be removed.';
        }

        $logger->notice( $message, [ __METHOD__ ] );
    }

}
