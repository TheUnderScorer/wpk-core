<?php

/**
 * This file is used to store project modules.
 *
 * In order to add module you only need to add reference to it's class (that extends base Module class) to array below.
 */

use UnderScorer\Core\CoreModule;

return apply_filters( 'wpk/modules', [
    'core' => CoreModule::class,
] );
