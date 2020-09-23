<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\AddressValidation;

use Rawilk\Ups\Entity\Entity;

/**
 * @property int $code
 * @property null|string $description
 */
class AddressClassification extends Entity
{
    /** @var int */
    public const UNKNOWN = 0;

    /** @var int */
    public const COMMERCIAL = 1;

    /** @var int */
    public const RESIDENTIAL = 2;

    protected $casts = [
        'code' => 'integer',
    ];
}
