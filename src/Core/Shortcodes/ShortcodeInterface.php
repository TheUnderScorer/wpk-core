<?php

namespace UnderScorer\Core\Shortcodes;

/**
 * @author Przemysław Żydek
 */
interface ShortcodeInterface
{

    /**
     * Renders shortcode content
     *
     * @param array $atts Shortcode attributes
     *
     * @return string
     */
    public function render( array $atts = [] ): string;

}
