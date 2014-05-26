<?php

namespace MyCLabs\UnitAPI\WebService;

use MyCLabs\UnitAPI\DTO\PhysicalQuantityDTO;
use MyCLabs\UnitAPI\DTO\TranslatedString;
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
        $response = $this->get('/unit/');

        $units = [];

        foreach ($response as $item) {
            $units[] = $this->getUnitDTO($item);
        }

        return $units;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnit($id)
    {
        $response = $this->get('/unit/' . urlencode($id));

        return $this->getUnitDTO($response);
    }

    /**
     * {@inheritdoc}
     */
    public function getCompatibleUnits($id)
    {
        $response = $this->get('/compatible-units/' . urlencode($id));

        $units = [];

        foreach ($response as $item) {
            $units[] = $this->getUnitDTO($item);
        }

        return $units;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnitOfReference($id)
    {
        $response = $this->get('/unit-of-reference/' . urlencode($id));

        return $this->getUnitDTO($response);
    }

    /**
     * {@inheritdoc}
     */
    public function getUnitSystems()
    {
        $response = $this->get('/unit-system/');

        $unitSystems = [];

        foreach ($response as $item) {
            $unitSystem = new UnitSystemDTO();
            $unitSystem->id = $item->id;
            $unitSystem->label = TranslatedString::fromArray((array) $item->label);

            $unitSystems[] = $unitSystem;
        }

        return $unitSystems;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhysicalQuantities()
    {
        $response = $this->get('/physical-quantity/');

        $quantities = [];

        foreach ($response as $item) {
            $quantity = new PhysicalQuantityDTO();
            $quantity->id = $item->id;
            $quantity->label = TranslatedString::fromArray((array) $item->label);
            $quantity->symbol = $item->symbol;
            $quantity->unitOfReference = $item->unitOfReference;

            $quantities[] = $quantity;
        }

        return $quantities;
    }

    private function getUnitDTO($item)
    {
        $unit = new UnitDTO();
        $unit->id = $item->id;
        $unit->label = TranslatedString::fromArray((array) $item->label);
        $unit->symbol = TranslatedString::fromArray((array) $item->symbol);
        $unit->type = $item->type;
        if (isset($item->unitSystem)) {
            $unit->unitSystem = $item->unitSystem;
        }
        if (isset($item->physicalQuantity)) {
            $unit->physicalQuantity = $item->physicalQuantity;
        }

        return $unit;
    }
}
