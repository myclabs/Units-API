<?php

namespace MyCLabs\UnitAPI\WebService;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Exception\RequestException;

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
     * @throws WebServiceException Error while calling the webservice
     * @return mixed Response of the webservice as a PHP array or object (stdClass)
     */
    protected function get($url)
    {
        $request = $this->httpClient->get($url);

        try {
            $response = $request->send();
        } catch (RequestException $e) {
            throw new WebServiceException('Error while calling the Units webservice: ' . $e->getMessage(), 0, $e);
        }

        return json_decode($response->getBody());
    }

    /**
     * Performs a HTTP POST request.
     *
     * @param string $url
     * @param array  $data POST data
     *
     * @throws WebServiceException
     * @return mixed Response of the webservice as a PHP array or object (stdClass)
     */
    protected function post($url, $data)
    {
        $request = $this->httpClient->post($url, null, $data);

        try {
            $response = $request->send();
        } catch (RequestException $e) {
            throw new WebServiceException('Error while calling the Units webservice: ' . $e->getMessage(), 0, $e);
        }

        return json_decode($response->getBody());
    }
}
