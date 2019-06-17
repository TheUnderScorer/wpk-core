<?php

use UnderScorer\Core\Storage\Cache;

// Set global cache instance
Cache::setGlobalInstance(
    new Cache( 'wpk', '+1 hour' )
);
