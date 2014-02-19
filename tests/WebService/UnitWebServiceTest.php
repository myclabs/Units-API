<?php

namespace UnitTest\MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use MyCLabs\UnitAPI\DTO\UnitDTO;
use MyCLabs\UnitAPI\WebService\UnitWebService;

/**
 * @covers \MyCLabs\UnitAPI\WebService\UnitWebService
 */
class UnitWebServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUnitsEmpty()
    {
        $service = $this->createService('[]');

        $units = $service->getUnits('en');

        $this->assertInternalType('array', $units);
        $this->assertEmpty($units);
    }

    public function testGetUnit()
    {
        $service = $this->createService(json_encode([
            'id'               => 'm',
            'label'            => 'meter',
            'symbol'           => 'm',
            'type'             => 'standard',
            'unitSystem'       => 'international',
            'physicalQuantity' => 'l',
        ]));

        $unit = $service->getUnit('m', 'en');

        $this->assertTrue($unit instanceof UnitDTO);
        $this->assertEquals('m', $unit->id);
        $this->assertEquals('meter', $unit->label);
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     */
    public function testGetUnitNotFound()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Unknown unit m',
            'unitId'    => 'm',
        ]), 404);
        $service->getUnit('m', 'en');
    }

    public function testGetCompatibleUnitsEmpty()
    {
        $service = $this->createService('[]');

        $units = $service->getCompatibleUnits('m', 'en');

        $this->assertInternalType('array', $units);
        $this->assertEmpty($units);
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     */
    public function testGetCompatibleUnitsNotFound()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Unknown unit m',
            'unitId'    => 'm',
        ]), 404);
        $service->getCompatibleUnits('m', 'en');
    }

    public function testGetUnitOfReference()
    {
        $service = $this->createService(json_encode([
            'id'               => 'm',
            'label'            => 'meter',
            'symbol'           => 'm',
            'type'             => 'standard',
            'unitSystem'       => 'international',
            'physicalQuantity' => 'l',
        ]));

        $unit = $service->getUnitOfReference('km', 'en');

        $this->assertTrue($unit instanceof UnitDTO);
        $this->assertEquals('m', $unit->id);
        $this->assertEquals('meter', $unit->label);
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     */
    public function testGetUnitOfReferenceNotFound()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Unknown unit m',
            'unitId'    => 'm',
        ]), 404);
        $service->getUnitOfReference('m', 'en');
    }

    private function createService($responseBody, $responseCode = 200)
    {
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response($responseCode, null, $responseBody));
        $httpClient = new Client();
        $httpClient->addSubscriber($plugin);

        return new UnitWebService($httpClient);
    }
}
