<?php

namespace MyCLabs\UnitAPI\Operation;

/**
 * Unit operation builder.
 *
 * Example usage:
 *
 *     $operation = OperationBuilder::addition()
 *         ->with('m', 2)
 *         ->with('h', -2)
 *         ->getOperation();
 *
 * @author matthieu.napoli
 */
class OperationBuilder
{
    /**
     * @var Operation
     */
    private $operation;

    /**
     * @return OperationBuilder
     */
    public static function addition()
    {
        return new static(new Addition());
    }

    /**
     * @return OperationBuilder
     */
    public static function multiplication()
    {
        return new static(new Multiplication());
    }

    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    /**
     * @param string $unitId
     * @param int    $exponent
     *
     * @return $this
     */
    public function with($unitId, $exponent = 1)
    {
        $this->operation->addComponent(new OperationComponent($unitId, $exponent));

        return $this;
    }

    /**
     * @return Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }
}
