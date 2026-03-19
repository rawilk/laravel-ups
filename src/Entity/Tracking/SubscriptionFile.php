<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Tracking;

use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $file_name
 * @property Delivery $delivery
 * @property Manifest $manifest
 * @property Origin $origin
 * @property StatusType $status_type
 */
class SubscriptionFile extends Entity
{
    public function delivery(): string
    {
        return Delivery::class;
    }

    public function manifest(): string
    {
        return Manifest::class;
    }

    public function origin(): string
    {
        return Origin::class;
    }

    public function statusType(): string
    {
        return StatusType::class;
    }

    protected function booted(): void
    {
        // Let's set our relationship defaults to new instances:
        $relations = [
            'status_type' => $this->statusType(),
            'manifest' => $this->manifest(),
            'delivery' => $this->delivery(),
            'origin' => $this->origin(),
        ];

        foreach ($relations as $attribute => $relatedClass) {
            $this->setAttribute($attribute, new $relatedClass);
        }
    }
}
