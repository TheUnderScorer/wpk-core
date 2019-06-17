<?php

namespace UnderScorer\Core\Models;

use Exception;

/**
 * Trait for models that might have authors
 *
 * @author Przemysław Żydek
 */
trait WithAuthor
{

    /**
     * @var int
     */
    public $authorID = 0;

    /**
     * @return User
     * @throws Exception
     */
    public function getAuthor(): User
    {
        return User::find( $this->authorID );
    }

}
