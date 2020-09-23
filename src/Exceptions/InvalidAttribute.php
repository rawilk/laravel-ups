<?php

declare(strict_types=1);

namespace Rawilk\Ups\Exceptions;

use InvalidArgumentException;

class InvalidAttribute extends InvalidArgumentException
{
    public static function withMessage(string $message): self
    {
        return new static($message);
    }
}
