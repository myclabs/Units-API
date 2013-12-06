<?php

namespace MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Client;
use MyCLabs\UnitAPI\DTO\PhysicalQuantityDTO;
use MyCLabs\UnitAPI\DTO\UnitDTO;
use MyCLabs\UnitAPI\DTO\UnitSystemDTO;
use MyCLabs\UnitAPI\UnitService;

/**
 * Implementation of the UnitService using the webservice.
 *
 * @author matthieu.napoli
 */
class UnitWebService implements UnitService
{
    /**
     * @var Client
     */
    private $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnits()
    {
        $request = $this->httpClient->get('unit/');
        $response = $request->send();

        $raw = json_decode($response->getBody());

        $units = [];

        foreach ($raw as $item) {
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
        $request = $this->httpClient->get('unit/');
        $response = $request->send();

        $raw = json_decode($response->getBody());

        $unit = new UnitDTO();
        $unit->id = $raw->id;
        $unit->label = $raw->label;
        $unit->symbol = $raw->symbol;
        $unit->type = $raw->type;
        if (isset($raw->unitSystem)) {
            $unit->unitSystem = $raw->unitSystem;
        }
        if (isset($raw->physicalQuantity)) {
            $unit->physicalQuantity = $raw->physicalQuantity;
        }

        return $unit;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnitSystems()
    {
        $request = $this->httpClient->get('unit-system/');
        $response = $request->send();

        $raw = json_decode($response->getBody());

        $unitSystems = [];

        foreach ($raw as $item) {
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
        $request = $this->httpClient->get('physical-quantity/');
        $response = $request->send();

        $raw = json_decode($response->getBody());

        $quantities = [];

        foreach ($raw as $item) {
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
