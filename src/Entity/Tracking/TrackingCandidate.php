<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Tracking;

use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $tracking_number
 * @property null|string $destination_postal_code
 * @property null|string $destination_country_code
 * @property PickupDateRange $pickup_date_range
 */
class TrackingCandidate extends Entity
{
    public function pickupDateRange(): string
    {
        return PickupDateRange::class;
    }
}
