<?php

namespace MyCLabs\UnitAPI;

use MyCLabs\UnitAPI\DTO\UnitDTO;
use MyCLabs\UnitAPI\DTO\UnitSystemDTO;
use MyCLabs\UnitAPI\DTO\PhysicalQuantityDTO;
use MyCLabs\UnitAPI\Exception\UnknownUnitException;

/**
 * Service that provides units.
 */
interface UnitService
{
    /**
     * Returns all known units.
     *
     * @return UnitDTO[]
     */
    public function getUnits();

    /**
     * Returns a unit.
     *
     * @param string $id Expression identifying the unit.
     *
     * @throws UnknownUnitException
     * @return UnitDTO
     */
    public function getUnit($id);

    /**
     * Returns all units compatible with the given unit.
     *
     * @param string $id Expression identifying a unit.
     *
     * @throws UnknownUnitException
     * @return UnitDTO[] Compatible units.
     */
    public function getCompatibleUnits($id);

    /**
     * Returns the unit of reference of the given unit.
     *
     * The unit of reference would be the unit of reference of the same physical quantity.
     * For example, m is the unit of reference for km, and m^2 for km^2.
     *
     * @param string $id Expression identifying a unit.
     *
     * @throws UnknownUnitException
     * @return UnitDTO
     */
    public function getUnitOfReference($id);

    /**
     * Returns all systems of units.
     *
     * @return UnitSystemDTO[]
     */
    public function getUnitSystems();

    /**
     * Returns all physical quantities.
     *
     * @return PhysicalQuantityDTO[]
     */
    public function getPhysicalQuantities();
}
