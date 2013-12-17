<?php

namespace MyCLabs\UnitAPI\WebService;

use MyCLabs\UnitAPI\UnitOperationService;

/**
 * Implementation of the UnitOperationService using the webservice.
 *
 * @author matthieu.napoli
 */
class UnitOperationWebService extends BaseWebService implements UnitOperationService
{
    /**
     * {@inheritdoc}
     */
    public function getConversionFactor($unit1, $unit2)
    {
        $response = $this->get('conversion-factor?unit1=' . urlencode($unit1) . '&unit2=' . urlencode($unit2));

        return (float) $response;
    }

    /**
     * {@inheritdoc}
     */
    public function areCompatible($unit1, $unit2)
    {
        $query = http_build_query(['units' => func_get_args()]);

        $response = $this->get('compatible?' . $query);

        return (boolean) $response;
    }

    /**
     * {@inheritdoc}
     */
    public function multiply($unit1, $unit2)
    {
        $query = http_build_query(['units' => func_get_args()]);

        $response = $this->get('multiply?' . $query);

        return (string) $response;
    }

    /**
     * {@inheritdoc}
     */
    public function inverse($unit)
    {
        $response = $this->get('inverse/' . urlencode($unit));

        return (string) $response;
    }
}
