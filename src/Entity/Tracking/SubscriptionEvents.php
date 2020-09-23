<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Tracking;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $name
 * @property string $number
 * @property \Rawilk\Ups\Entity\Tracking\SubscriptionStatus $subscription_status
 * @property \Rawilk\Ups\Entity\Tracking\DateRange $date_range
 */
class SubscriptionEvents extends Entity
{
    public function dateRange(): string
    {
        return DateRange::class;
    }

    public function subscriptionStatus(): string
    {
        return SubscriptionStatus::class;
    }

    protected function booted(): void
    {
        $this->setAttribute('date_range', new DateRange);
        $this->setAttribute('subscription_status', new SubscriptionStatus);
    }
}
