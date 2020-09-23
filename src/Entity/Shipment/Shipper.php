<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Exceptions\InvalidAttribute;

/**
 * @property string $name
 *      Shipper's company name. for forward shipment 35 characters are accepted, but only 30 characters will
 *      be printed on the label.
 * @property null|string $attention_name
 * @property null|string $company_displayable_name
 * @property string $shipper_number
 *      Shipper's six digit account number. Must be associated with the UserId specified in the AccessRequest XML.
 * @property null|string $tax_identification_number
 * @property null|string $phone_number
 * @property null|string $fax_number
 * @property null|string $email
 * @property \Rawilk\Ups\Entity\Address\Address $address
 *      The package should be returned to this address if the package is undeliverable.
 */
class Shipper extends Entity
{
    /** @var int */
    public const MAX_NAME_LENGTH = 35;

    /** @var int */
    public const SHIPPER_NUMBER_LENGTH = 6;

    public function setNameAttribute($name): void
    {
        $this->attributes['name'] = $this->truncateName($name);
    }

    public function setAttentionNameAttribute($name): void
    {
        $this->attributes['attention_name'] = $this->truncateName($name);
    }

    public function setCompanyDisplayableNameAttribute($name): void
    {
        $this->attributes['company_displayable_name'] = $this->truncateName($name);
    }

    public function setShipperNumberAttribute($shipperNumber): void
    {
        if (! $this->isShipperNumberValid($shipperNumber)) {
            throw InvalidAttribute::withMessage('Your shipper number is not valid for this shipment.');
        }

        $this->attributes['shipper_number'] = $shipperNumber;
    }

    public function getEmailXmlTag(): string
    {
        return 'EMailAddress';
    }

    public function address(): string
    {
        return Address::class;
    }

    protected function truncateName(string $name): string
    {
        if (strlen($name) <= self::MAX_NAME_LENGTH) {
            return $name;
        }

        return substr($name, 0, self::MAX_NAME_LENGTH);
    }

    protected function isShipperNumberValid($shipperNumber): bool
    {
        return ! empty($shipperNumber) && strlen($shipperNumber) === self::SHIPPER_NUMBER_LENGTH;
    }
}
