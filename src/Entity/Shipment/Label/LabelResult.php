<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\Label;

use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\Receipt\Receipt;

/**
 * @property null|string $tracking_number
 *      Package Tracking number. Package 1Z number. Returned only if TrackingNumber or Combination of Reference Number
 *      and Shipper Number is present in request.
 * @property \Rawilk\Ups\Entity\Shipment\Label\LabelImage $label_image
 * @property null|\Rawilk\Ups\Entity\Shipment\Receipt\Receipt $receipt
 */
class LabelResult extends Entity
{
    public function labelImage(): string
    {
        return LabelImage::class;
    }

    public function receipt(): string
    {
        return Receipt::class;
    }
}
