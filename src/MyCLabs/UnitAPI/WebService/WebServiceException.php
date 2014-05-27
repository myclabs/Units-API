<?php

namespace MyCLabs\UnitAPI\WebService;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;

/**
 * Error while trying to reach the webservice.
 */
class WebServiceException extends \RuntimeException
{
    public static function create(RequestException $e, $message = null)
    {
        if ($e instanceof BadResponseException) {
            return new self(sprintf(
                'Error while calling the Units webservice: %s %s',
                $e->getResponse()->getStatusCode(),
                $message ?: $e->getResponse()->getBody()
            ), 0, $e);
        }

        return new WebServiceException('Error while calling the Units webservice: ' . $message ?: $e->getMessage(), 0, $e);
    }
}
