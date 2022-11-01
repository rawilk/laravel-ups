<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity;

/**
 * @property null|string $language_code
 * @property null|string $dialect_code
 * @property null|string $code
 * @property null|string $locale
 */
class Translate extends Entity
{
    public const DEFAULT_CODE = 'en_US';
}
