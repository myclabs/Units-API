<?php

namespace MyCLabs\UnitAPI;

use MyCLabs\UnitAPI\DTO\UnitDTO;
use MyCLabs\UnitAPI\DTO\UnitSystemDTO;
use MyCLabs\UnitAPI\DTO\PhysicalQuantityDTO;

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
     * @return UnitDTO
     */
    public function getUnit($id);

    /**
     * Returns all units compatible with the given unit.
     *
     * @param string $id Expression identifying a unit.
     *
     * @return UnitDTO[] Compatible units.
     */
    public function getCompatibleUnits($id);

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
