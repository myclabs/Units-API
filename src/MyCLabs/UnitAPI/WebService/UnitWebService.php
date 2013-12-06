<?php

namespace MyCLabs\UnitAPI\WebService;

use MyCLabs\UnitAPI\DTO\PhysicalQuantityDTO;
use MyCLabs\UnitAPI\DTO\UnitDTO;
use MyCLabs\UnitAPI\DTO\UnitSystemDTO;
use MyCLabs\UnitAPI\UnitService;

/**
 * Implementation of the UnitService using the webservice.
 *
 * @author matthieu.napoli
 */
class UnitWebService extends BaseWebService implements UnitService
{
    /**
     * {@inheritdoc}
     */
    public function getUnits()
    {
        $response = $this->get('unit/');

        $units = [];

        foreach ($response as $item) {
            $unit = new UnitDTO();
            $unit->id = $item->id;
            $unit->label = $item->label;
            $unit->symbol = $item->symbol;
            $unit->type = $item->type;
            if (isset($item->unitSystem)) {
                $unit->unitSystem = $item->unitSystem;
            }
            if (isset($item->physicalQuantity)) {
                $unit->physicalQuantity = $item->physicalQuantity;
            }

            $units[] = $unit;
        }

        return $units;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnit($id)
    {
        $response = $this->get('unit/' . urlencode($id) . '/');

        $unit = new UnitDTO();
        $unit->id = $response->id;
        $unit->label = $response->label;
        $unit->symbol = $response->symbol;
        $unit->type = $response->type;
        if (isset($response->unitSystem)) {
            $unit->unitSystem = $response->unitSystem;
        }
        if (isset($response->physicalQuantity)) {
            $unit->physicalQuantity = $response->physicalQuantity;
        }

        return $unit;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnitSystems()
    {
        $response = $this->get('unit-system/');

        $unitSystems = [];

        foreach ($response as $item) {
            $unitSystem = new UnitSystemDTO();
            $unitSystem->id = $item->id;
            $unitSystem->label = $item->label;

            $unitSystems[] = $unitSystem;
        }

        return $unitSystems;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhysicalQuantities()
    {
        $response = $this->get('physical-quantity/');

        $quantities = [];

        foreach ($response as $item) {
            $quantity = new PhysicalQuantityDTO();
            $quantity->id = $item->id;
            $quantity->label = $item->label;
            $quantity->symbol = $item->symbol;
            $quantity->unitOfReference = $item->unitOfReference;

            $quantities[] = $quantity;
        }

        return $quantities;
    }
}
