<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Tracking\DateRange;
use Rawilk\Ups\Entity\Tracking\SubscriptionEvents;
use Rawilk\Ups\Entity\Tracking\SubscriptionStatus;

it('sets the default values', function () {
    $entity = new SubscriptionEvents;

    expect($entity->date_range)->toBeInstanceOf(DateRange::class)
        ->and($entity->subscription_status)->toBeInstanceOf(SubscriptionStatus::class);
});
