<?php

namespace MyCLabs\UnitAPI;

use MyCLabs\UnitAPI\Exception\UnknownUnitException;

/**
 * Service that converts values from a unit to another.
 */
interface OperationService
{
    /**
     * Returns the conversion factor between two compatible units.
     *
     * @param string $unit1 Expression of the source unit.
     * @param string $unit2 Expression of the target unit.
     *
     * @throws UnknownUnitException
     * @return Value New value object containing the new unit and the converted value.
     */
    public function getConversionFactor($unit1, $unit2);
}
