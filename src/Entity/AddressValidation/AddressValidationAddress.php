<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\AddressValidation;

use Rawilk\Ups\Concerns\HasAddressMapping;
use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $address_line1
 * @property null|string $address_line2
 * @property null|string $address_line3
 * @property null|string $city
 * @property null|string $state
 * @property null|string $postal_code
 * @property null|string $postcode_extended_low
 *      Low-end extended postal code in a range. Example in quotes: Postal Code 30076-'1234'. Only returned in candidate list. May be alphanumeric.
 * @property string $country_code
 * @property null|string $consignee_name Name of business, company or person. Not returned if user selects the RegionalRequestIndicator.
 * @property null|string $building_name Name of building. Not returned if user selects the RegionalRequestIndicator.
 * @property null|string $urbanization Puerto Rico Political Division 3. Only valid for Puerto Rico.
 * @property null|\Rawilk\Ups\Entity\AddressValidation\AddressClassification $address_classification
 */
class AddressValidationAddress extends Entity
{
    use HasAddressMapping;

    protected array $attributeKeyMap = [
        'political_division1' => 'state',
        'political_division2' => 'city',
        'postcode_primary_low' => 'postal_code',
    ];

    public function addressClassification(): string
    {
        return AddressClassification::class;
    }

    protected function filled(array $attributes): void
    {
        $this->mapPostalCode($attributes);
    }
}
