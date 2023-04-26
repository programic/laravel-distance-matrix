<?php

namespace Programic\DistanceMatrix\Exceptions;

use Exception;
use Throwable;

class OverDailyLimitException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Distance Matrix: Over daily limit', $code, $previous);
    }
}
