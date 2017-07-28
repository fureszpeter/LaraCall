<?php
namespace A2bApiClient\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;

class A2bApiException extends Exception
{
    public function __construct(ClientException $exception)
    {
        parent::__construct(
            $exception->getResponse()->getBody(),
            $exception->getResponse()->getStatusCode(),
            $exception
        );
    }

}
