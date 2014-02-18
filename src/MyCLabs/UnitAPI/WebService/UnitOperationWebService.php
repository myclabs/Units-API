<?php

namespace MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Exception\BadResponseException;
use MyCLabs\UnitAPI\Exception\IncompatibleUnitsException;
use MyCLabs\UnitAPI\Exception\UnknownUnitException;
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

        try {
            $response = $this->get('execute?' . $query, false);
        } catch (BadResponseException $e) {
            $exception = json_decode($e->getResponse()->getBody());

            // Unknown unit
            if ($e->getResponse()->getStatusCode() === 404) {
                throw new UnknownUnitException($exception->message, $exception->unitId);
            }

            // Incompatible units
            if ($e->getResponse()->getStatusCode() === 400) {
                throw new IncompatibleUnitsException($exception->message);
            }

            throw WebServiceException::create($e);
        }

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
        try {
            $response = $this->get($url, false);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
            $matches = [];

            // Unknown unit
            if (($response->getStatusCode() === 404)
                && preg_match('/^UnknownUnitException: Unknown unit (.+)$/', $response->getBody(), $matches)
            ) {
                throw UnknownUnitException::create($matches[1]);
            }

            // Incompatible units
            if (($response->getStatusCode() === 400)
                && preg_match('/^IncompatibleUnitsException: (.+)$/', $response->getBody(), $matches)
            ) {
                throw new IncompatibleUnitsException($matches[1]);
            }

            throw WebServiceException::create($e);
        }

        return (float) $response;
    }

    /**
     * {@inheritdoc}
     */
    public function areCompatible($unit1, $unit2)
    {
        $query = http_build_query(['units' => func_get_args()]);

        try {
            $response = $this->get('compatible?' . $query, false);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
            $matches = [];

            // Unknown unit
            if (($response->getStatusCode() === 404)
                && preg_match('/^UnknownUnitException: Unknown unit (.+)$/', $response->getBody(), $matches)
            ) {
                throw UnknownUnitException::create($matches[1]);
            }

            throw WebServiceException::create($e);
        }

        return (boolean) $response;
    }

    /**
     * {@inheritdoc}
     */
    public function inverse($unit)
    {
        try {
            $response = $this->get('inverse/' . urlencode($unit), false);
        } catch (BadResponseException $e) {
            if (($e->getResponse()->getStatusCode() === 404)
                && (strpos($e->getResponse()->getBody(), 'UnknownUnitException') === 0)
            ) {
                throw UnknownUnitException::create($unit);
            }
            throw WebServiceException::create($e);
        }

        return (string) $response;
    }
}
