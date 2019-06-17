<?php

namespace UnderScorer\Core\Models;

use UnderScorer\Core\Models\Factories\ModelFactoryInterface;

/**
 * Trait for models with factories
 *
 * @property array $factories Property that must be declared in parent class
 *
 * @author Przemysław Żydek
 */
trait WithFactory
{

    /**
     * @param string $factory
     * @param array  $args
     *
     * @return ModelFactoryInterface
     */
    public static function factory( string $factory, array $args = [] ): ModelFactoryInterface
    {
        $factory = self::getFactory( $factory );

        return new $factory( new static, $args );
    }

    /**
     * @param string $factory
     *
     * @return string
     */
    public static function getFactory( string $factory ): string
    {
        return static::$factories[ $factory ];
    }

}
