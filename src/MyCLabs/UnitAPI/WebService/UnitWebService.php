<?php

namespace MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Client;
use MyCLabs\UnitAPI\DTO\UnitDTO;
use MyCLabs\UnitAPI\UnitService;

/**
 * Implementation of the UnitService using the webservice.
 *
 * @author matthieu.napoli
 */
class UnitWebService implements UnitService
{
    const ENDPOINT = 'unit/';

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
        $request = $this->httpClient->get(self::ENDPOINT);
        $response = $request->send();

        $raw = json_decode($response->getBody());

        $units = [];

        foreach ($raw as $item) {
            $unit = new UnitDTO();
            $unit->id = $item->id;
            $unit->label = $item->label;
            $unit->symbol = $item->symbol;
            if (isset($item->unitSystem)) {
                $unit->unitSystem = $item->unitSystem;
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
        $request = $this->httpClient->get(self::ENDPOINT);
        $response = $request->send();

        $raw = json_decode($response->getBody());

        $unit = new UnitDTO();
        $unit->id = $raw->id;
        $unit->label = $raw->label;
        $unit->symbol = $raw->symbol;
        if (isset($raw->unitSystem)) {
            $unit->unitSystem = $raw->unitSystem;
        }

        return $unit;
    }
}
