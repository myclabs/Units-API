<?php

namespace UnitTest\MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use MyCLabs\UnitAPI\DTO\UnitDTO;
use MyCLabs\UnitAPI\WebService\UnitWebService;

class UnitWebServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUnitsEmpty()
    {
        $service = $this->createService('[]');

        $units = $service->getUnits();

        $this->assertInternalType('array', $units);
        $this->assertEmpty($units);
    }

    public function testGetUnit()
    {
        $service = $this->createService('{"id":"m","label":"m\u00e8tre","symbol":"m","type":"standard","unitSystem":"international","physicalQuantity":"l"}');

        $unit = $service->getUnit('m');

        $this->assertTrue($unit instanceof UnitDTO);
        $this->assertEquals('m', $unit->id);
        $this->assertEquals('mètre', $unit->label);
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     */
    public function testGetUnitNotFound()
    {
        $service = $this->createService('UnknownUnitException: Unknown unit m', 404);
        $service->getUnit('m');
    }

    public function testGetCompatibleUnitsEmpty()
    {
        $service = $this->createService('[]');

        $units = $service->getCompatibleUnits('m');

        $this->assertInternalType('array', $units);
        $this->assertEmpty($units);
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     */
    public function testGetCompatibleUnitsNotFound()
    {
        $service = $this->createService('UnknownUnitException: Unknown unit m', 404);
        $service->getCompatibleUnits('m');
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
