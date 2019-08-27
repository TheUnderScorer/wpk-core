<?php

namespace UnderScorer\Core\Http\ResponseContents;

use UnderScorer\Core\Utility\AttributeBuilder;

/**
 * @author Przemysław Żydek
 */
class ResponseContent implements ResponseContentInterface
{

    use AttributeBuilder;

    /**
     * @var mixed Response result
     */
    public $result = false;

    /**
     * BaseResponse constructor.
     *
     * @param array $attributes
     */
    public function __construct( array $attributes = [] )
    {
        $this->parseAttributes( $attributes );
    }

    /**
     * @param array $attributes
     *
     * @return static
     */
    public static function make( array $attributes = [] )
    {
        return new static( $attributes );
    }

    /**
     * @inheritDoc
     */
    public function toJson(): string
    {
        return json_encode( $this->toArray() );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return get_object_vars( $this );
    }

}
