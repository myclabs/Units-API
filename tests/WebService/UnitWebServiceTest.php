<?php

namespace UnitTest\MyCLabs\UnitAPI\WebService;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use MyCLabs\UnitAPI\DTO\TranslatedString;
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

        $units = $service->getUnits();

        $this->assertInternalType('array', $units);
        $this->assertEmpty($units);
    }

    public function testGetUnit()
    {
        $service = $this->createService(json_encode([
            'id'               => 'm',
            'label'            => ['en' => 'meter', 'fr' => 'mètre'],
            'symbol'           => ['en' => 'm', 'fr' => 'm'],
            'type'             => 'standard',
            'unitSystem'       => 'international',
            'physicalQuantity' => 'l',
        ]));

        $unit = $service->getUnit('m');

        $this->assertTrue($unit instanceof UnitDTO);
        $this->assertEquals('m', $unit->id);

        $this->assertTrue($unit->label instanceof TranslatedString);
        $this->assertEquals('meter', $unit->label->en);
        $this->assertEquals('mètre', $unit->label->fr);

        $this->assertTrue($unit->symbol instanceof TranslatedString);
        $this->assertEquals('m', $unit->symbol->en);
        $this->assertEquals('m', $unit->symbol->fr);
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
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message'   => 'Unknown unit m',
            'unitId'    => 'm',
        ]), 404);
        $service->getCompatibleUnits('m');
    }

    public function testGetUnitOfReference()
    {
        $service = $this->createService(json_encode([
            'id'               => 'm',
            'label'            => ['en' => 'meter', 'fr' => 'mètre'],
            'symbol'           => ['en' => 'm', 'fr' => 'm'],
            'type'             => 'standard',
            'unitSystem'       => 'international',
            'physicalQuantity' => 'l',
        ]));

        $unit = $service->getUnitOfReference('km');

        $this->assertTrue($unit instanceof UnitDTO);
        $this->assertEquals('m', $unit->id);

        $this->assertTrue($unit->label instanceof TranslatedString);
        $this->assertEquals('meter', $unit->label->en);
        $this->assertEquals('mètre', $unit->label->fr);
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
        $service->getUnitOfReference('m');
    }

    private function createService($responseBody, $responseCode = 200)
    {
        $mock = new Mock([
            new Response($responseCode, [], Stream::factory($responseBody)),
        ]);
        $httpClient = new Client();
        $httpClient->getEmitter()->attach($mock);

        return new UnitWebService($httpClient);
    }
}
