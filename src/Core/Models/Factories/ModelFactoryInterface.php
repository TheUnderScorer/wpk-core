<?php

namespace UnderScorer\Core\Models\Factories;

use Exception;
use UnderScorer\Core\Models\Model;
use UnderScorer\Core\Models\ModelInterface;

/**
 * Inteface for factories that create models
 *
 * @author Przemysław Żydek
 */
interface ModelFactoryInterface
{

    /**
     * ModelFactory constructor.
     *
     * @param ModelInterface $baseModel
     * @param array          $args
     */
    public function __construct( ModelInterface $baseModel, array $args = [] );

    /**
     * @return Model
     * @throws Exception
     */
    public function create();

    /**
     * @param array $args
     *
     * @return static
     */
    public function setArgs( array $args );

    /**
     * @return array
     */
    public function getArgs(): array;

}
