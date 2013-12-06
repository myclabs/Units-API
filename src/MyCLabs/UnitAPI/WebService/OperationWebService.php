<?php

namespace MyCLabs\UnitAPI\WebService;

use MyCLabs\UnitAPI\OperationService;

/**
 * Implementation of the OperationService using the webservice.
 *
 * @author matthieu.napoli
 */
class OperationWebService extends BaseWebService implements OperationService
{
    /**
     * {@inheritdoc}
     */
    public function getConversionFactor($unit1, $unit2)
    {
        $response = $this->get('conversion-factor/' . urlencode($unit1) . '/' . urlencode($unit2));

        return (float) $response;
    }
}
