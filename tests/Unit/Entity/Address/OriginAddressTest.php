<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\AddressKeyFormat;
use Rawilk\Ups\Entity\Address\OriginAddress;
use Rawilk\Ups\Entity\Location\Geocode;

it('has address key format', function () {
    $xml = <<<'XML'
    <OriginAddress>
        <AddressKeyFormat>
            <City>Atlanta</City>
        </AddressKeyFormat>
    </OriginAddress>
    XML;

    $originAddress = OriginAddress::fromXml(new SimpleXMLElement($xml));

    $expected = ['city' => 'Atlanta'];

    expect($originAddress->address_key_format)->toBeInstanceOf(AddressKeyFormat::class)
        ->and($originAddress->address_key_format->toArray())->toEqual($expected);
});

it('converts address key format to xml', function () {
    $originAddress = new OriginAddress([
        'address_key_format' => new AddressKeyFormat([
            'city' => 'Atlanta',
        ]),
    ]);

    $expectedXml = <<<'XML'
    <OriginAddress>
        <MaximumListSize>10</MaximumListSize>
        <AddressKeyFormat>
            <City>Atlanta</City>
        </AddressKeyFormat>
    </OriginAddress>
    XML;

    $this->assertXmlStringEqualsXmlString(
        $expectedXml,
        $originAddress->toSimpleXml(null, false)->asXML(),
    );
});

it('can have a geocode', function () {
    $xml = <<<'XML'
    <OriginAddress>
        <Geocode>
            <Latitude>123456</Latitude>
            <Longitude>654321</Longitude>
        </Geocode>
    </OriginAddress>
    XML;

    $originAddress = OriginAddress::fromXml(new SimpleXMLElement($xml));

    expect($originAddress->geocode)->toBeInstanceOf(Geocode::class)
        ->and($originAddress->geocode->latitude)->toBe('123456')
        ->and($originAddress->geocode->longitude)->toBe('654321');
});

it('can render geocode to xml', function () {
    $originAddress = new OriginAddress([
        'geocode' => new Geocode([
            'latitude' => '123456',
            'longitude' => '654321',
        ]),
    ]);

    $expectedXml = <<<'XML'
    <OriginAddress>
        <MaximumListSize>10</MaximumListSize>
        <Geocode>
            <Latitude>123456</Latitude>
            <Longitude>654321</Longitude>
        </Geocode>
    </OriginAddress>
    XML;

    $this->assertXmlStringEqualsXmlString(
        $expectedXml,
        $originAddress->toSimpleXml(null, false)->asXML(),
    );
});

it('can have a custom list size', function () {
    $originAddress = new OriginAddress(['maximum_list_size' => 5]);

    $expectedXml = <<<'XML'
    <OriginAddress>
        <MaximumListSize>5</MaximumListSize>
    </OriginAddress>
    XML;

    $this->assertXmlStringEqualsXmlString(
        $expectedXml,
        $originAddress->toSimpleXml(null, false)->asXML(),
    );
});
