<?php

namespace UnitTest\MyCLabs\UnitAPI\WebService;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use MyCLabs\UnitAPI\WebService\BaseWebService;

/**
 * @covers \MyCLabs\UnitAPI\WebService\BaseWebService
 */
class BaseWebServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\UnknownUnitException
     * @expectedExceptionMessage Foo bar
     */
    public function testUnknownUnitException()
    {
        $service = $this->createService(json_encode([
            'exception' => 'UnknownUnitException',
            'message' => 'Foo bar',
            'unitId' => 'kg',
        ]), 404);

        $service->doGet();
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\Exception\IncompatibleUnitsException
     * @expectedExceptionMessage Foo bar
     */
    public function testIncompatibleUnitsException()
    {
        $service = $this->createService(json_encode([
            'exception' => 'IncompatibleUnitsException',
            'message' => 'Foo bar',
        ]), 400);

        $service->doGet();
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\WebService\WebServiceException
     * @expectedExceptionMessage Error while calling the Units webservice: 400 Foo bar
     */
    public function testAnyExceptionWithMessage()
    {
        $service = $this->createService(json_encode([
            'message' => 'Foo bar',
        ]), 400);

        $service->doGet();
    }

    /**
     * @expectedException \MyCLabs\UnitAPI\WebService\WebServiceException
     * @expectedExceptionMessage Error while calling the Units webservice: 400
     */
    public function testAnyExceptionWithoutMessage()
    {
        $service = $this->createService('', 400);

        $service->doGet();
    }

    private function createService($responseBody, $responseCode = 200)
    {
        $mock = new Mock([
            new Response($responseCode, [], Stream::factory($responseBody)),
        ]);
        $httpClient = new Client();
        $httpClient->getEmitter()->attach($mock);

        return new MockImplementation($httpClient);
    }
}

class MockImplementation extends BaseWebService
{
    public function doGet()
    {
        return $this->get('foo');
    }
}
