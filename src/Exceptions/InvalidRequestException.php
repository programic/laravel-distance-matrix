<?php

namespace Programic\DistanceMatrix\Exceptions;

use Exception;

class InvalidRequestException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Distance Matrix: Invalid request', $code, $previous);
    }
}