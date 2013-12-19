<?php

namespace MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Exception\BadResponseException;
use MyCLabs\UnitAPI\DTO\PhysicalQuantityDTO;
use MyCLabs\UnitAPI\DTO\UnitDTO;
use MyCLabs\UnitAPI\DTO\UnitSystemDTO;
use MyCLabs\UnitAPI\Exception\UnknownUnitException;
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
        try {
            $response = $this->get('unit/' . urlencode($id), false);
        } catch (BadResponseException $e) {
            if (($e->getResponse()->getStatusCode() === 404)
                && (strpos($e->getResponse()->getBody(), 'UnknownUnitException') === 0)
            ) {
                throw UnknownUnitException::create($id);
            }
            throw WebServiceException::create($e);
        }

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
    public function getCompatibleUnits($id)
    {
        try {
            $response = $this->get('compatible-units/' . urlencode($id), false);
        } catch (BadResponseException $e) {
            if (($e->getResponse()->getStatusCode() === 404)
                && (strpos($e->getResponse()->getBody(), 'UnknownUnitException') === 0)
            ) {
                throw UnknownUnitException::create($id);
            }
            throw WebServiceException::create($e);
        }

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
