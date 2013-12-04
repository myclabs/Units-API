<?php

namespace MyCLabs\UnitAPI;

use MyCLabs\UnitAPI\DTO\UnitDTO;

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
}
