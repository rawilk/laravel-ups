<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $location_id
 *      LocationID is a unique identifier referring to a specific shipping/receiving location.
 * @property string $receiving_address_name
 * @property string $bookmark
 * @property string $shipper_assigned_identification_number
 * @property string $company_name Consignee's company name.
 * @property null|string $attention_name Contact name at the consignee's location.
 * @property string $phone_number
 * @property string $tax_identification_number
 * @property string $fax_number
 * @property string $email_address
 * @property \Rawilk\Ups\Entity\Address\Address $address
 */
class ShipTo extends Entity
{
    public function getEmailAddressXmlTag(): string
    {
        return 'EMailAddress';
    }

    public function getLocationIdXmlTag(): string
    {
        return 'LocationID';
    }

    public function address(): string
    {
        return Address::class;
    }

    protected function booted(): void
    {
        // Let's default the address to a new instance.
        $this->setAttribute('address', new Address);
    }
}
