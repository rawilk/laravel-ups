<?php

declare(strict_types=1);

namespace Rawilk\Ups\Responses\Tracking;

use Rawilk\Ups\Concerns\HandlesApiFailures;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\Shipment;

/** @property \Rawilk\Ups\Entity\Shipment\Shipment $shipment */
class TrackingResponse extends Entity
{
    use HandlesApiFailures;

    private const NO_TRACKING_CODE = '151044';

    private const INVALID_TRACKING_CODE = '151018';

    public function shipment(): string
    {
        return Shipment::class;
    }

    /*
     * Error handling convenience methods.
     */

    public function noTrackingInformationAvailable(): bool
    {
        return $this->error_code === self::NO_TRACKING_CODE;
    }

    public function invalidTrackingNumber(): bool
    {
        return $this->error_code === self::INVALID_TRACKING_CODE;
    }
}
