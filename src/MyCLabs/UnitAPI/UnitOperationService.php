<?php

namespace MyCLabs\UnitAPI;

use MyCLabs\UnitAPI\Exception\IncompatibleUnitsException;
use MyCLabs\UnitAPI\Exception\UnknownUnitException;
use MyCLabs\UnitAPI\Operation\Operation;
use MyCLabs\UnitAPI\Operation\Result\OperationResult;

/**
 * Service that performs operations on units.
 *
 * @author matthieu.napoli
 */
interface UnitOperationService
{
    /**
     * Executes a operation operation of units.
     *
     * For example:
     *     km * h^-1 = km.h^-1
     *     m^2 * m^-1 = m
     *
     * @param Operation $operation
     *
     * @throws UnknownUnitException One of the unit is unknown.
     * @return OperationResult Result of the operation.
     */
    public function execute(Operation $operation);

    /**
     * Returns the conversion factor between two compatible units.
     *
     * WARNING: note that this is the conversion factor between the two units.
     * This is the *inverse* of the conversion factor you can use to convert values.
     *
     * To convert a value from unit 1 to unit 2:
     *     Value in unit 1 / conversion factor = value in unit 2
     *
     * e.g. 1 km = 1000 m (the conversion factor here is 1000)
     *      To convert a value in km to m, you need to divide by the conversion factor:
     *      ? km / 1000 => ? m
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
     * Inverses a unit.
     *
     * For example:
     *     m -> m^-1
     *     km . h^-1 = km^-1 . h
     *
     * @param string $unit Expression of a unit.
     *
     * @throws UnknownUnitException The unit is unknown.
     * @return string Inverse of the given unit.
     */
    public function inverse($unit);
}
