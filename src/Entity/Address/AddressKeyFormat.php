<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Address;

use Rawilk\Ups\Concerns\HasAddressMapping;

/**
 * @property null|string $single_line_address
 */
class AddressKeyFormat extends Address
{
    use HasAddressMapping;

    protected array $attributeKeyMap = [
        'political_division1' => 'state',
        'political_division2' => 'city',
        'postcode_primary_low' => 'postal_code',
    ];

    protected function filled(array $attributes): void
    {
        $this->mapPostalCode($attributes);
    }
}
