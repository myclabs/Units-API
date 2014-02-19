<?php

namespace UnitTest\MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use MyCLabs\UnitAPI\Operation\OperationBuilder;
use MyCLabs\UnitAPI\WebService\UnitOperationWebService;

/**
 * @covers \MyCLabs\UnitAPI\WebService\UnitOperationWebService
 */
class UnitOperationWebServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConversionFactor()
    {
        $service = $this->createService('0.001');

        $this->assertEquals(0.001, $service->getConversionFactor('m', 'km'));
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Unknown unit m
     */
    public function testGetConversionFactorUnitNotFound1()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Unknown unit m',
            'unitId'    => 'm'
        ]), 404);
        $service->getConversionFactor('m', 'km');
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Unknown unit km
     */
    public function testGetConversionFactorUnitNotFound2()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Unknown unit km',
            'unitId'    => 'km'
        ]), 404);
        $service->getConversionFactor('m', 'km');
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\IncompatibleUnitsException
     * @expectedExceptionMessage Conversion factor impossible: units "m" and "g" have different physical quantities: "l" and "m"
     */
    public function testGetConversionFactorIncompatibleUnits()
    {
        $service = $this->createService(json_encode([
            'exception' => 'IncompatibleUnitsException',
            'message'   => 'Conversion factor impossible: units "m" and "g" have different physical quantities: "l" and "m"',
        ]), 400);
        $service->getConversionFactor('m', 'g');
    }

    public function testAreCompatible()
    {
        $service = $this->createService('false');

        $this->assertFalse($service->areCompatible('m', 'km'));
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Unknown unit m
     */
    public function testAreCompatibleUnitNotFound1()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Unknown unit m',
            'unitId'    => 'm',
        ]), 404);
        $service->areCompatible('m', 'km');
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Unknown unit km
     */
    public function testAreCompatibleUnitNotFound2()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Unknown unit km',
            'unitId'    => 'km',
        ]), 404);
        $service->areCompatible('m', 'km');
    }

    public function testAddition()
    {
        $service = $this->createService(json_encode([
            'unitId' => 'kg',
        ]));

        $operation = OperationBuilder::addition()
            ->with('g')
            ->with('kg')
            ->getOperation();

        $operationResult = $service->execute($operation);

        $this->assertInstanceOf('MyCLabs\UnitAPI\Operation\Result\AdditionResult', $operationResult);
        $this->assertEquals('kg', $operationResult->getUnitId());
    }

    public function testMultiplication()
    {
        $service = $this->createService(json_encode([
            'unitId' => 'm.kg',
            'conversionFactor' => 1.,
        ]));

        $operation = OperationBuilder::multiplication()
            ->with('m')
            ->with('kg')
            ->getOperation();

        $operationResult = $service->execute($operation);

        $this->assertInstanceOf('MyCLabs\UnitAPI\Operation\Result\MultiplicationResult', $operationResult);
        $this->assertEquals('m.kg', $operationResult->getUnitId());
        $this->assertEquals(1., $operationResult->getConversionFactor());
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Unknown unit m
     */
    public function testMultiplicationUnitNotFound1()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Unknown unit m',
            'unitId'    => 'm',
        ]), 404);

        $operation = OperationBuilder::multiplication()
            ->with('m')
            ->with('g')
            ->getOperation();

        $service->execute($operation);
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Invalid unit expression '': Expected UNIT_ID, but got end of input.
     */
    public function testMultiplicationUnitNotFound2()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Invalid unit expression \'\': Expected UNIT_ID, but got end of input.',
            'unitId'    => '',
        ]), 404);

        $operation = OperationBuilder::multiplication()
            ->with('m')
            ->with('g')
            ->getOperation();

        $service->execute($operation);
    }

    public function testInverse()
    {
        $service = $this->createService('"m^-1"');

        $this->assertEquals('m^-1', $service->inverse('m'));
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Unknown unit m
     */
    public function testInverseUnitNotFound()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Unknown unit m',
            'unitId'    => 'm',
        ]), 404);
        $service->inverse('m');
    }

    private function createService($responseBody, $responseCode = 200)
    {
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response($responseCode, null, $responseBody));
        $httpClient = new Client();
        $httpClient->addSubscriber($plugin);

        return new UnitOperationWebService($httpClient);
    }
}
