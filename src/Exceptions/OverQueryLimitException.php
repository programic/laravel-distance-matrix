<?php

namespace Programic\DistanceMatrix\Exceptions;

use Exception;
use Throwable;

class OverQueryLimitException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Distance Matrix: Over query limit', $code, $previous);
    }
}
