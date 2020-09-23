<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Entity;

/**
 * SoldTo is the person or company who imports and pays any duties
 * due on the current shipment. The Sold To party's country code must
 * be the same as the Ship To party's country code with the exception
 * of Canada and satellite countries.
 *
 * @property null|string $option
 * @property null|string $company_name
 * @property null|string $attention_name Contact name.
 * @property null|string $tax_identification_number
 * @property null|string $phone_number
 * @property null|\Rawilk\Ups\Entity\Address\Address $address
 */
class SoldTo extends Entity
{
    public function address(): string
    {
        return Address::class;
    }
}
