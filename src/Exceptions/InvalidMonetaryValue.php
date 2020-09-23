<?php

declare(strict_types=1);

namespace Rawilk\Ups\Exceptions;

use InvalidArgumentException;

class InvalidMonetaryValue extends InvalidArgumentException
{
    public static function invalid(float $min, float $max): self
    {
        return new static(
            sprintf(
                'Invalid monetary value. Valid values are between %s and %s.',
                $min,
                $max
            )
        );
    }
}
