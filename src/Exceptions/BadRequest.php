<?php

declare(strict_types=1);

namespace Rawilk\Ups\Exceptions;

use BadMethodCallException;

class BadRequest extends BadMethodCallException
{
    public static function minSuggestionsNotMet(): self
    {
        return new static('[UPS] At least one suggestion should be provided.');
    }

    public static function maxSuggestionsExceeded(int $max): self
    {
        return new static("[UPS] Maximum of {$max} suggestions allowed.");
    }

    public static function invalidRequestOption(): self
    {
        return new static('[UPS] Invalid request option supplied.');
    }

    public static function missingRequiredData(string $message = null): self
    {
        return new static("[UPS] Request is missing required data. {$message}");
    }

    public static function invalidData(string $message): self
    {
        return new static("[UPS] {$message}");
    }
}
