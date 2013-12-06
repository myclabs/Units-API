<?php

namespace MyCLabs\UnitAPI;

use MyCLabs\UnitAPI\Exception\IncompatibleUnitsException;
use MyCLabs\UnitAPI\Exception\UnknownUnitException;

/**
 * Service that converts values from a unit to another.
 */
interface OperationService
{
    /**
     * Returns the conversion factor between two compatible units.
     *
     * This conversion factor allows to convert a value from unit 1 to unit 2:
     *     Value in unit 1 * conversion factor = value in unit 2
     *
     * @param string $unit1 Expression of the source unit.
     * @param string $unit2 Expression of the target unit.
     *
     * @throws UnknownUnitException       One of the unit is unknown.
     * @throws IncompatibleUnitsException Units are incompatible (e.g. not the same physical quantity).
     *
     * @return float Conversion factor.
     */
    public function getConversionFactor($unit1, $unit2);
}
