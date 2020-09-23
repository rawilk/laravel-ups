<?php

declare(strict_types=1);

namespace Rawilk\Ups\Exceptions;

use Exception;

class InvalidRequest extends Exception
{
    public static function missingEndpoint(): self
    {
        return new static('The UPS api request is missing an endpoint to send the request to.');
    }

    public static function missingAuthentication(): self
    {
        return new static('The authentication for the UPS api request is missing or incomplete.');
    }
}
