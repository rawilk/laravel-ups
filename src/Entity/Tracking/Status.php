<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Tracking;

use Rawilk\Ups\Entity\Entity;

/**
 * @property StatusType $status_type
 * @property null|StatusCode $status_code
 */
class Status extends Entity
{
    public function statusType(): string
    {
        return StatusType::class;
    }

    public function statusCode(): string
    {
        return StatusCode::class;
    }

    public function isPickup(): bool
    {
        if (! $this->status_type) {
            return false;
        }

        return $this->status_type->isPickup();
    }

    public function isDelivered(): bool
    {
        if (! $this->status_type) {
            return false;
        }

        return $this->status_type->isDelivered();
    }
}
