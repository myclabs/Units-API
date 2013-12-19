<?php

namespace MyCLabs\UnitAPI\WebService;

use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Exception\RequestException;

/**
 * Error while trying to reach the webservice.
 */
class WebServiceException extends \RuntimeException
{
    public static function create(RequestException $e)
    {
        if ($e instanceof BadResponseException) {
            return new self(sprintf(
                'Error while calling the Units webservice: %s %s',
                $e->getResponse()->getStatusCode(),
                $e->getResponse()->getBody()
            ), 0, $e);
        }

        return new WebServiceException('Error while calling the Units webservice: ' . $e->getMessage(), 0, $e);
    }
}
