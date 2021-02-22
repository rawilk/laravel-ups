<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Address;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $address_line1
 * @property string $address_line2
 * @property string $address_line3
 * @property string $attention_name
 * @property string $city
 * @property string $consignee_name
 * @property string $state
 * @property string $country_code
 * @property string $postal_code
 * @property bool $residential
 */
class Address extends Entity
{
    protected bool $isForValidation = false;

    protected $casts = [
        'residential' => 'boolean',
    ];

    /*
     * Used internally by the AddressValidationApi to correctly map out
     * certain property xml tags.
     */
    public function isForValidation(): self
    {
        $this->isForValidation = true;

        return $this;
    }

    public function getAddressLine1XmlTag(): string
    {
        return $this->isForValidation ? 'AddressLine' : 'AddressLine1';
    }

    public function getAddressLine2XmlTag(): string
    {
        return $this->isForValidation ? 'AddressLine' : 'AddressLine2';
    }

    public function getAddressLine3XmlTag(): string
    {
        return $this->isForValidation ? 'AddressLine' : 'AddressLine3';
    }

    public function getAttentionNameXmlTag(): string
    {
        return 'ConsigneeName';
    }

    public function getCityXmlTag(): string
    {
        return $this->isForValidation ? 'PoliticalDivision2' : 'City';
    }

    public function getPostalCodeXmlTag(): string
    {
        return $this->isForValidation ? 'PostcodePrimaryLow' : 'PostalCode';
    }

    public function getStateXmlTag(): string
    {
        return $this->isForValidation ? 'PoliticalDivision1' : 'StateProvinceCode';
    }

    public function getResidentialXmlTag(): string
    {
        return 'ResidentialAddress';
    }
}
