<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\AddressKeyFormat;

it('maps to xml correctly', function () {
    $addressKeyFormat = new AddressKeyFormat([
        'address_line1' => '200 warsaw rd',
        'political_division2' => 'Atlanta',
        'political_division1' => 'GA',
        'postcode_primary_low' => '85281',
        'postcode_extended_low' => '4510',
        'country_code' => 'US',
    ]);

    $expectedXml = <<<'XML'
    <AddressKeyFormat>
        <AddressLine1>200 warsaw rd</AddressLine1>
        <City>Atlanta</City>
        <StateProvinceCode>GA</StateProvinceCode>
        <PostalCode>85281-4510</PostalCode>
        <CountryCode>US</CountryCode>
    </AddressKeyFormat>
    XML;

    $this->assertXmlStringEqualsXmlString(
        $expectedXml,
        $addressKeyFormat->toSimpleXml(null, false)->asXML(),
    );
});
