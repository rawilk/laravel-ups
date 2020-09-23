<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Tracking;

use Rawilk\Ups\Entity\Tracking\DateRange;
use Rawilk\Ups\Entity\Tracking\SubscriptionEvents;
use Rawilk\Ups\Entity\Tracking\SubscriptionStatus;
use Rawilk\Ups\Tests\TestCase;

class SubscriptionEventsTest extends TestCase
{
    /** @test */
    public function sets_default_values(): void
    {
        $entity = new SubscriptionEvents;

        self::assertInstanceOf(DateRange::class, $entity->date_range);
        self::assertInstanceOf(SubscriptionStatus::class, $entity->subscription_status);
    }
}
