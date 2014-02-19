<?php

namespace MyCLabs\UnitAPI\WebService;

use MyCLabs\UnitAPI\Operation\Addition;
use MyCLabs\UnitAPI\Operation\Multiplication;
use MyCLabs\UnitAPI\Operation\Operation;
use MyCLabs\UnitAPI\Operation\OperationComponent;
use MyCLabs\UnitAPI\Operation\Result\AdditionResult;
use MyCLabs\UnitAPI\Operation\Result\MultiplicationResult;
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
    public function execute(Operation $operation)
    {
        switch ($operation) {
            case $operation instanceof Addition:
                $operationType = 'addition';
                break;
            case $operation instanceof Multiplication:
                $operationType = 'multiplication';
                break;
            default:
                throw new \Exception;
        }

        $components = array_map(function (OperationComponent $component) {
            return [
                'unit' => $component->getUnitId(),
                'exponent' => $component->getExponent(),
            ];
        }, $operation->getComponents());

        $query = http_build_query([
            'operation'  => $operationType,
            'components' => $components,
        ]);

        $response = $this->get('execute?' . $query);

        switch ($operation) {
            case $operation instanceof Addition:
                return new AdditionResult($response->unitId);
            case $operation instanceof Multiplication:
                return new MultiplicationResult($response->unitId, $response->conversionFactor);
            default:
                throw new \Exception;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConversionFactor($unit1, $unit2)
    {
        $url = 'conversion-factor?unit1=' . urlencode($unit1) . '&unit2=' . urlencode($unit2);

        return (float) $this->get($url);
    }

    /**
     * {@inheritdoc}
     */
    public function areCompatible($unit1, $unit2)
    {
        $query = http_build_query(['units' => func_get_args()]);

        return (boolean) $this->get('compatible?' . $query);
    }

    /**
     * {@inheritdoc}
     */
    public function inverse($unit)
    {
        return (string) $this->get('inverse/' . urlencode($unit));
    }
}
