<?php

namespace UnderScorer\Core\Models;

/**
 * Interface for models that contain link to content
 *
 * @author Przemysław Żydek
 */
interface ModelWithLink
{

    /**
     * Get model permalink
     *
     * @return string
     */
    public function getPermalink(): string;

}
