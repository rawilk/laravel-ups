<?php

declare(strict_types=1);

namespace Rawilk\Ups\Responses\Tracking;

use Rawilk\Ups\Concerns\HandlesApiFailures;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\Shipment;

/**
 * @property \Rawilk\Ups\Entity\Shipment\Shipment $shipment
 */
class TrackingResponse extends Entity
{
    use HandlesApiFailures;

    public function shipment(): string
    {
        return Shipment::class;
    }

    /*
     * Error handling convenience methods.
     */

    public function noTrackingInformationAvailable(): bool
    {
        return $this->error_code === '151044';
    }

    public function invalidTrackingNumber(): bool
    {
        return $this->error_code === '151018';
    }
}
