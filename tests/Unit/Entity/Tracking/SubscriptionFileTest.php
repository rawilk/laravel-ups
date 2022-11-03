<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Tracking\Delivery;
use Rawilk\Ups\Entity\Tracking\Manifest;
use Rawilk\Ups\Entity\Tracking\Origin;
use Rawilk\Ups\Entity\Tracking\StatusType;
use Rawilk\Ups\Entity\Tracking\SubscriptionFile;

it('defaults relations to new instances', function () {
    $entity = new SubscriptionFile;

    expect($entity->status_type)->toBeInstanceOf(StatusType::class)
        ->and($entity->manifest)->toBeInstanceOf(Manifest::class)
        ->and($entity->origin)->toBeInstanceOf(Origin::class)
        ->and($entity->delivery)->toBeInstanceOf(Delivery::class);
});
