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
     * @param string $locale
     *
     * @return UnitDTO[]
     */
    public function getUnits($locale);

    /**
     * Returns a unit.
     *
     * @param string $id     Expression identifying the unit.
     * @param string $locale
     *
     * @throws UnknownUnitException
     * @return UnitDTO
     */
    public function getUnit($id, $locale);

    /**
     * Returns all units compatible with the given unit.
     *
     * @param string $id     Expression identifying a unit.
     * @param string $locale
     *
     * @throws UnknownUnitException
     * @return UnitDTO[] Compatible units.
     */
    public function getCompatibleUnits($id, $locale);

    /**
     * Returns the unit of reference of the given unit.
     *
     * The unit of reference would be the unit of reference of the same physical quantity.
     * For example, m is the unit of reference for km, and m^2 for km^2.
     *
     * @param string $id     Expression identifying a unit.
     * @param string $locale
     *
     * @throws UnknownUnitException
     * @return UnitDTO
     */
    public function getUnitOfReference($id, $locale);

    /**
     * Returns all systems of units.
     *
     * @param string $locale
     *
     * @return UnitSystemDTO[]
     */
    public function getUnitSystems($locale);

    /**
     * Returns all physical quantities.
     *
     * @param string $locale
     *
     * @return PhysicalQuantityDTO[]
     */
    public function getPhysicalQuantities($locale);
}
