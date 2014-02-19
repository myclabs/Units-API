<?php

namespace MyCLabs\UnitAPI\WebService;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Exception\RequestException;
use Guzzle\Http\Message\RequestInterface;
use MyCLabs\UnitAPI\Exception\IncompatibleUnitsException;
use MyCLabs\UnitAPI\Exception\UnknownUnitException;

/**
 * Base class for webservice implementations.
 *
 * @author matthieu.napoli
 */
class BaseWebService
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @param ClientInterface $httpClient Client to use to perform HTTP requests.
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Performs a HTTP GET request.
     *
     * @param string $url
     *
     * @throws UnknownUnitException
     * @throws IncompatibleUnitsException
     * @throws WebServiceException
     *
     * @return mixed Response of the webservice as a PHP array or object (stdClass)
     */
    protected function get($url)
    {
        $response = $this->sendRequest($this->httpClient->get($url));

        return json_decode($response->getBody());
    }

    /**
     * Performs a HTTP POST request.
     *
     * @param string $url
     * @param array  $data POST data
     *
     *
     * @throws UnknownUnitException
     * @throws IncompatibleUnitsException
     * @throws WebServiceException
     *
     * @return mixed Response of the webservice as a PHP array or object (stdClass)
     */
    protected function post($url, $data)
    {
        $response = $this->sendRequest($this->httpClient->post($url, null, $data));

        return json_decode($response->getBody());
    }

    private function sendRequest(RequestInterface $request)
    {
        try {
            return $request->send();
        } catch (BadResponseException $e) {
            $exception = json_decode($e->getResponse()->getBody());

            // Error while decoding JSON response, or no exception type
            if ($exception === null || ! isset($exception->exception)) {
                throw WebServiceException::create($e);
            }

            // Unknown unit
            if ($exception->exception === 'UnknownUnitException' && isset($exception->unitId)) {
                throw new UnknownUnitException($exception->message, $exception->unitId);
            }

            // Incompatible units
            if ($exception->exception === 'IncompatibleUnitsException') {
                throw new IncompatibleUnitsException($exception->message);
            }

            throw WebServiceException::create($e);
        } catch (RequestException $e) {
            throw WebServiceException::create($e);
        }
    }
}
