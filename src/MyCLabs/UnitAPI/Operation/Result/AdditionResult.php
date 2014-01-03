<?php

namespace MyCLabs\UnitAPI\Operation\Result;

/**
 * Unit addition result.
 *
 * @author matthieu.napoli
 */
class AdditionResult extends OperationResult
{
    public function __construct($unit)
    {
        $this->unitId = $unit;
    }
}
