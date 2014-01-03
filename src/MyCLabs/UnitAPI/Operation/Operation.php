<?php

namespace MyCLabs\UnitAPI\Operation;

/**
 * Unit mathematical operation.
 *
 * @author matthieu.napoli
 */
abstract class Operation
{
    /**
     * @var OperationComponent[]
     */
    private $components;

    public function __construct(array $components = [])
    {
        $this->components = $components;
    }

    public function addComponent(OperationComponent $component)
    {
        $this->components[] = $component;
    }

    /**
     * @return OperationComponent[]
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @return string
     */
    abstract public function __toString();
}
