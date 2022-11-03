<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;

it('can convert to xml', function () {
    $address = new Address([
        'address_line1' => '7510 AIRWAY RD',
        'address_line2' => 'STE 7',
        'city' => 'SAN DIEGO',
        'state' => 'CA',
        'postal_code' => '92154',
        'country_code' => 'US',
    ]);

    $this->assertXmlStringEqualsXmlString(
        getXmlContent('address')->asXML(),
        $address->toSimpleXml()->asXML(),
    );
});

it('can convert to xml for validation', function () {
    $address = new Address([
        'address_line1' => '7510 AIRWAY RD',
        'address_line2' => 'STE 7',
        'city' => 'SAN DIEGO',
        'state' => 'CA',
        'postal_code' => '92154',
        'country_code' => 'US',
    ]);

    $this->assertXmlStringEqualsXmlString(
        getXmlContent('address-for-validation')->asXML(),
        $address->isForValidation()->toSimpleXml()->asXML(),
    );
});

test('residential property is boolean', function () {
    $address = new Address([
        'residential' => 1,
    ]);

    expect($address->residential)->toBeBool()
        ->and($address->residential)->toBeTrue();
});

it('omits the residential property in the xml when it is false', function () {
    $expectedXml = <<<'XML'
    <Address>
        <City>Foo</City>
    </Address>
    XML;

    $address = new Address([
        'city' => 'Foo',
        'residential' => false,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expectedXml,
        $address->toSimpleXml(null, false)->asXML(),
    );
});

test('residential property is included as a self closing empty tag in xml when it is true', function () {
    $expectedXml = <<<'XML'
    <Address>
        <City>Foo</City>
        <ResidentialAddress />
    </Address>
    XML;

    $address = new Address([
        'city' => 'Foo',
        'residential' => true,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expectedXml,
        $address->toSimpleXml(null, false)->asXML(),
    );
});
