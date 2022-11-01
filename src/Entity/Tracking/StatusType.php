<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Tracking;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 * @property null|string $description
 */
class StatusType extends Entity
{
    // Valid codes:
    public const IN_TRANSIT = 'I';

    public const DELIVERED = 'D';

    public const EXCEPTION = 'X';

    public const PICKUP = 'P';

    public const MANIFEST_PICKUP = 'M';

    public function isPickup(): bool
    {
        return $this->code === static::PICKUP;
    }

    public function isDelivered(): bool
    {
        return $this->code === static::DELIVERED;
    }
}
