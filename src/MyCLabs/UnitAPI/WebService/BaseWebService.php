<?php

namespace MyCLabs\UnitAPI\WebService;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Message\RequestInterface;
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
        $response = $this->sendRequest($this->httpClient->createRequest('GET', $url));

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
        $request = $this->httpClient->createRequest('POST', $url, [
            'body' => $data,
        ]);
        $response = $this->sendRequest($request);

        return json_decode($response->getBody());
    }

    private function sendRequest(RequestInterface $request)
    {
        try {
            return $this->httpClient->send($request);
        } catch (BadResponseException $e) {
            $exception = json_decode($e->getResponse()->getBody());

            // Error while decoding JSON response, or no exception type
            if ($exception === null) {
                throw WebServiceException::create($e);
            }

            // No exception type
            if (! isset($exception->exception)) {
                if (isset($exception->message)) {
                    throw WebServiceException::create($e, $exception->message);
                }

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
