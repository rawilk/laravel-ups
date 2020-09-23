<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Tracking;

use Rawilk\Ups\Entity\Tracking\Delivery;
use Rawilk\Ups\Entity\Tracking\Manifest;
use Rawilk\Ups\Entity\Tracking\Origin;
use Rawilk\Ups\Entity\Tracking\StatusType;
use Rawilk\Ups\Entity\Tracking\SubscriptionFile;
use Rawilk\Ups\Tests\TestCase;

class SubscriptionFileTest extends TestCase
{
    /** @test */
    public function defaults_relations_to_new_instances(): void
    {
        $entity = new SubscriptionFile;

        self::assertInstanceOf(StatusType::class, $entity->status_type);
        self::assertInstanceOf(Manifest::class, $entity->manifest);
        self::assertInstanceOf(Origin::class, $entity->origin);
        self::assertInstanceOf(Delivery::class, $entity->delivery);
    }
}
