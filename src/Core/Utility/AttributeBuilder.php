<?php

namespace UnderScorer\Core\Utility;

/**
 * @author Przemysław Żydek
 */
trait AttributeBuilder
{

    /**
     * @param array $attributes
     *
     * @return void
     */
    protected function parseAttributes( array $attributes )
    {

        foreach ( $attributes as $key => $attribute ) {

            if ( property_exists( $this, $key ) ) {
                $this->$key = $attribute;
            } else if ( property_exists( $this, 'attributes' ) ) {
                $this->attributes[ $key ] = $attribute;
            }

        }

    }

}
