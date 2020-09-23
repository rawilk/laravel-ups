<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Entity;

/**
 * @property string $company_name Origin location's company name.
 * @property null|string $attention_name Contact name at the pickup location.
 * @property null|string $tax_identification_number
 *      Company's tax identification number at the pickup location.
 * @property null|\Rawilk\Ups\Entity\Shipment\TaxIDType $tax_id_type
 *      Applies to EEI form only.
 * @property null|string $phone_number Origin location's phone number.
 * @property null|string $fax_number Origin location's fax number.
 * @property \Rawilk\Ups\Entity\Address\Address $address Address of the pickup location.
 */
class ShipFrom extends Entity
{
    /** @var int */
    public const MAX_NAME_LENGTH = 35;

    public function setCompanyNameAttribute($companyName): void
    {
        $this->attributes['company_name'] = $this->truncateName($companyName);
    }

    public function setAttentionNameAttribute($attentionName): void
    {
        $this->attributes['attention_name'] = $this->truncateName($attentionName);
    }

    protected function truncateName(string $name): string
    {
        if (strlen($name) <= self::MAX_NAME_LENGTH) {
            return $name;
        }

        return substr($name, 0, self::MAX_NAME_LENGTH);
    }

    public function address(): string
    {
        return Address::class;
    }

    public function taxIdType(): string
    {
        return TaxIDType::class;
    }
}
