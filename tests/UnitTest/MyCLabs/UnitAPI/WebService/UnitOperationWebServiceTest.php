<?php

namespace UnitTest\MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
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
        $service = $this->createService('UnknownUnitException: Unknown unit m', 404);
        $service->getConversionFactor('m', 'km');
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Unknown unit km
     */
    public function testGetConversionFactorUnitNotFound2()
    {
        $service = $this->createService('UnknownUnitException: Unknown unit km', 404);
        $service->getConversionFactor('m', 'km');
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\IncompatibleUnitsException
     * @expectedExceptionMessage Conversion factor impossible: units "m" and "g" have different physical quantities: "l" and "m"
     */
    public function testGetConversionFactorIncompatibleUnits()
    {
        $service = $this->createService(
            'IncompatibleUnitsException: Conversion factor impossible: '
            . 'units "m" and "g" have different physical quantities: "l" and "m"',
            400
        );
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
        $service = $this->createService('UnknownUnitException: Unknown unit m', 404);
        $service->areCompatible('m', 'km');
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Unknown unit km
     */
    public function testAreCompatibleUnitNotFound2()
    {
        $service = $this->createService('UnknownUnitException: Unknown unit km', 404);
        $service->areCompatible('m', 'km');
    }

    public function testMultiply()
    {
        $service = $this->createService('"m.g"');

        $this->assertEquals('m.g', $service->multiply('m', 'g'));
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Unknown unit m
     */
    public function testMultiplyUnitNotFound1()
    {
        $service = $this->createService('UnknownUnitException: Unknown unit m', 404);
        $service->multiply('m', 'g');
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Unknown unit g
     */
    public function testMultiplyUnitNotFound2()
    {
        $service = $this->createService('UnknownUnitException: Unknown unit g', 404);
        $service->multiply('m', 'g');
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
        $service = $this->createService('UnknownUnitException: Unknown unit m', 404);
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
