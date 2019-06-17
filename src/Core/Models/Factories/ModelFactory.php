<?php

namespace UnderScorer\Core\Models\Factories;

use UnderScorer\Core\Models\Model;
use UnderScorer\Core\Models\ModelInterface;

/**
 * @author Przemysław Żydek
 */
abstract class ModelFactory implements ModelFactoryInterface
{

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $args = [];

    /**
     * ModelFactory constructor.
     *
     * @param ModelInterface $baseModel
     * @param array          $args
     */
    public function __construct( ModelInterface $baseModel, array $args = [] )
    {
        $this->model = $baseModel;
        $this->args  = $args;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param array $args
     *
     * @return static
     */
    public function setArgs( array $args )
    {
        $this->args = $args;

        return $this;
    }


}
