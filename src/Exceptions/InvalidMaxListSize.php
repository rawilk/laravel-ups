<?php

declare(strict_types=1);

namespace Rawilk\Ups\Exceptions;

use InvalidArgumentException;

class InvalidMaxListSize extends InvalidArgumentException
{
    public static function invalid(int $min, int $max, int $default): self
    {
        return new static(
            sprintf(
                'Invalid maximum list size. Value must be between %s and %s. Default is %s.',
                $min,
                $max,
                $default
            )
        );
    }
}
