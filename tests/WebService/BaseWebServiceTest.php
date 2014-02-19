<?php

namespace UnitTest\MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
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

    private function createService($responseBody, $responseCode = 200)
    {
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response($responseCode, null, $responseBody));
        $httpClient = new Client();
        $httpClient->addSubscriber($plugin);

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
