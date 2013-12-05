<?php

namespace MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Client;
use MyCLabs\UnitAPI\ConversionService;
use MyCLabs\UnitAPI\Value;

/**
 * Implementation of the ConversionService using the webservice.
 *
 * @author matthieu.napoli
 */
class ConversionWebService implements ConversionService
{
    const ENDPOINT = 'convert/';

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
    public function convert(Value $value, $targetUnit)
    {
        $data = [
            'targetUnit' => $targetUnit,
            'value'      => $value->serialize(),
        ];

        $request = $this->httpClient->post(self::ENDPOINT, null, $data);
        $response = $request->send();

        $raw = json_decode($response->getBody());

        return Value::unserialize($raw->value);
    }
}
