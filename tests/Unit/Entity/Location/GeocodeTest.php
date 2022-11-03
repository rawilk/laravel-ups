<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Location\Geocode;

it('converts to xml', function () {
    $expected = <<<'XML'
    <Geocode>
        <Latitude>123456</Latitude>
        <Longitude>654321</Longitude>
    </Geocode>
    XML;

    $geocode = new Geocode([
        'latitude' => '123456',
        'longitude' => '654321',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $geocode->toSimpleXml(null, false)->asXML(),
    );
});

it('creates from xml', function () {
    $xml = <<<'XML'
    <Geocode>
        <Latitude>123456</Latitude>
        <Longitude>654321</Longitude>
    </Geocode>
    XML;

    $geocode = Geocode::fromXml(new SimpleXMLElement($xml));

    expect($geocode->toArray())->toEqual([
        'latitude' => '123456',
        'longitude' => '654321',
    ]);
});
