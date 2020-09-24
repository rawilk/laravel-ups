<?php

declare(strict_types=1);

namespace Rawilk\Ups\Responses\Shipping;

use Illuminate\Support\Collection;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Warning;

/**
 * @property string $shipment_identification_number
 *      Returned UPS shipment ID number; 1Z number of the first package in the shipment.
 * @property string $shipment_digest
 *      Encoded shipment parameters required to be passed in the accept phase.
 * @property \Illuminate\Support\Collection|\Rawilk\Ups\Entity\Warning[] $warnings
 */
class ShipConfirmResponse extends Entity
{
    public function getWarningsAttribute(): Collection
    {
        if (! $this->response || ! isset($this->response['error'])) {
            return collect();
        }

        return collect($this->response['error'])
            ->filter(fn (array $error) => $error['error_severity'] === 'Warning')
            ->map(fn (array $data) => new Warning($data));
    }
}
