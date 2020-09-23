<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Address;

use Rawilk\Ups\Entity\Address\AddressKeyFormat;
use Rawilk\Ups\Tests\TestCase;

class AddressKeyFormatTest extends TestCase
{
    /** @test */
    public function maps_to_xml_correctly(): void
    {
        $addressKeyFormat = new AddressKeyFormat([
            'address_line1' => '200 warsaw rd',
            'political_division2' => 'Atlanta',
            'political_division1' => 'GA',
            'postcode_primary_low' => '85281',
            'postcode_extended_low' => '4510',
            'country_code' => 'US',
        ]);

        $expectedXml = <<<XML
        <AddressKeyFormat>
            <AddressLine1>200 warsaw rd</AddressLine1>
            <City>Atlanta</City>
            <StateProvinceCode>GA</StateProvinceCode>
            <PostalCode>85281-4510</PostalCode>
            <CountryCode>US</CountryCode>
        </AddressKeyFormat>
        XML;

        self::assertXmlStringEqualsXmlString(
            $expectedXml,
            $addressKeyFormat->toSimpleXml(null, false)->asXML()
        );
    }
}
