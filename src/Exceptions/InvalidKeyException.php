<?php

namespace Programic\DistanceMatrix\Exceptions;

use Exception;
use Throwable;

class InvalidKeyException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Distance Matrix: Invalid or missing key', $code, $previous);
    }
}
