<?php

namespace MyCLabs\UnitAPI\Operation\Result;

/**
 * Unit operation result.
 *
 * @author matthieu.napoli
 */
abstract class OperationResult
{
    /**
     * @var string
     */
    protected $unitId;

    /**
     * Returns the unit of the result of the operation.
     *
     * @return string Unit ID.
     */
    public function getUnitId()
    {
        return $this->unitId;
    }
}
