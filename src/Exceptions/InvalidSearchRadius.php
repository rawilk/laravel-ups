<?php

declare(strict_types=1);

namespace Rawilk\Ups\Exceptions;

use InvalidArgumentException;

class InvalidSearchRadius extends InvalidArgumentException
{
    public static function invalid(int $min, int $max): self
    {
        return new static(
            sprintf(
                'Invalid search radius. Valid values are between %s and %s.',
                $min,
                $max
            )
        );
    }
}
