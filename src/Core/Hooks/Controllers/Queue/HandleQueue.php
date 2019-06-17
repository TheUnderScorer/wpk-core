<?php

namespace UnderScorer\Core\Hooks\Controllers\Queue;

use SuperClosure\Serializer;
use UnderScorer\Core\Cron\Queue\Queue;
use UnderScorer\Core\Hooks\Controllers\Cron\CronController;

/**
 * @author Przemysław Żydek
 */
class HandleQueue extends CronController
{

    /**
     * @inheritDoc
     */
    public function setup(): void
    {
        parent::setup();

        Queue::setCron( $this->cron );
    }

    /**
     * @param string $serializedClosure
     *
     * @return void
     */
    public function handle( string $serializedClosure = '' ): void
    {

        if ( ! $serializedClosure ) {
            return;
        }

        /** @var Serializer $serializer */
        $serializer = $this->app->getContainer()->get( Serializer::class );

        $closure = $serializer->unserialize( $serializedClosure );

        $closure();

    }
}
