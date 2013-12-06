<?php

namespace MyCLabs\UnitAPI\WebService;

use MyCLabs\UnitAPI\ConversionService;
use MyCLabs\UnitAPI\Value;

/**
 * Implementation of the ConversionService using the webservice.
 *
 * @author matthieu.napoli
 */
class ConversionWebService extends BaseWebService implements ConversionService
{
    /**
     * {@inheritdoc}
     */
    public function convert(Value $value, $targetUnit)
    {
        $data = [
            'targetUnit' => $targetUnit,
            'value'      => $value->serialize(),
        ];

        $response = $this->post('convert/', $data);

        return Value::unserialize($response->value);
    }
}
