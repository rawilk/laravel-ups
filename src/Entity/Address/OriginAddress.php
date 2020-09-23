<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Address;

use Rawilk\Ups\Concerns\HasFixedListSize;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Location\Geocode;

/**
 * @property int $maximum_list_size
 * @property \Rawilk\Ups\Entity\Address\AddressKeyFormat $address_key_format
 * @property \Rawilk\Ups\Entity\Location\Geocode $geocode
 */
class OriginAddress extends Entity
{
    use HasFixedListSize;

    public function addressKeyFormat(): string
    {
        return AddressKeyFormat::class;
    }

    public function geocode(): string
    {
        return Geocode::class;
    }
}
