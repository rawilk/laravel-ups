<?php

declare(strict_types=1);

namespace Rawilk\Ups\Exceptions;

use Exception;

class RequestFailed extends Exception
{
    public static function requestNotOk(int $code): self
    {
        return new static(
            "The UPS api request failed and returned code {$code}. Expected 200."
        );
    }

    public static function unexpectedFormat(): self
    {
        return new static('The UPS api request failed: response is in an unexpected format.');
    }

    public static function error(string $error, int $errorCode = null): self
    {
        return new static(
            "UPS api request failed: {$error} ({$errorCode})",
            $errorCode
        );
    }
}
