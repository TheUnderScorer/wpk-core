<?php

use UnderScorer\Core\Cron\Queue\Queue;
use UnderScorer\Core\Utility\Date;

// Email that will be sent in 10 seconds from now
Queue::add(
    function () {
        wp_mail( 'somebody@gmail.com', 'Hello there!', 'Sup bro' );
    },
    Date::now()->addSeconds( 10 )
);
