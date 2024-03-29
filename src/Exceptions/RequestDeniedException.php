<?php

namespace Programic\DistanceMatrix\Exceptions;

use Exception;
use Throwable;

class RequestDeniedException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Distance Matrix: Request denied', $code, $previous);
    }
}
