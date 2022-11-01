<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Rawilk\Ups\Entity\Location\Geocode;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class GeocodeTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
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

        self::assertXmlStringEqualsXmlString(
            $expected,
            $geocode->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<'XML'
        <Geocode>
            <Latitude>123456</Latitude>
            <Longitude>654321</Longitude>
        </Geocode>
        XML;

        $geocode = Geocode::fromXml(new SimpleXMLElement($xml));

        $expected = [
            'latitude' => '123456',
            'longitude' => '654321',
        ];

        self::assertEquals($expected, $geocode->toArray());
    }
}
