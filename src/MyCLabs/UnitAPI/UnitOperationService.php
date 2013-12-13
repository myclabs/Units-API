<?php

namespace MyCLabs\UnitAPI;

use MyCLabs\UnitAPI\Exception\IncompatibleUnitsException;
use MyCLabs\UnitAPI\Exception\UnknownUnitException;

/**
 * Service that performs operations on units.
 *
 * @author matthieu.napoli
 */
interface UnitOperationService
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

    /**
     * Returns true if the given units are compatible, false otherwise.
     *
     * Units are compatible if they have the same physical quantity.
     * Another way to put it is if they have the same unit of reference.
     *
     * @param string $unit1 Expression of a unit.
     * @param string $unit2 Expression of a unit.
     * @param string ...    This method can take more than 2 parameters and check that all units are compatible.
     *
     * @throws UnknownUnitException One of the unit is unknown.
     * @return boolean Units are compatible (true) or not (false).
     */
    public function areCompatible($unit1, $unit2);

    /**
     * Multiplies units and returns the resulting unit.
     *
     * For example:
     *     km * h^-1 = km.h^-1
     *     m^2 * m^-1 = m
     *
     * @param string $unit1 Expression of a unit.
     * @param string $unit2 Expression of a unit.
     * @param string ...    This method can take more than 2 parameters.
     *
     * @throws UnknownUnitException One of the unit is unknown.
     * @return string Resulting unit.
     */
    public function multiply($unit1, $unit2);
}
