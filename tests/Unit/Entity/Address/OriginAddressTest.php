<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Address;

use Rawilk\Ups\Entity\Address\AddressKeyFormat;
use Rawilk\Ups\Entity\Address\OriginAddress;
use Rawilk\Ups\Entity\Location\Geocode;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class OriginAddressTest extends TestCase
{
    /** @test */
    public function has_address_key_format(): void
    {
        $xml = <<<XML
        <OriginAddress>
            <AddressKeyFormat>
                <City>Atlanta</City>
            </AddressKeyFormat>
        </OriginAddress>
        XML;

        $originAddress = OriginAddress::fromXml(new SimpleXMLElement($xml));

        $expected = ['city' => 'Atlanta'];

        self::assertInstanceOf(AddressKeyFormat::class, $originAddress->address_key_format);
        self::assertEquals($expected, $originAddress->address_key_format->toArray());
    }

    /** @test */
    public function converts_address_key_format_to_xml(): void
    {
        $originAddress = new OriginAddress([
            'address_key_format' => new AddressKeyFormat([
                'city' => 'Atlanta',
            ]),
        ]);

        $expectedXml = <<<XML
        <OriginAddress>
            <MaximumListSize>10</MaximumListSize>
            <AddressKeyFormat>
                <City>Atlanta</City>
            </AddressKeyFormat>
        </OriginAddress>
        XML;

        self::assertXmlStringEqualsXmlString($expectedXml, $originAddress->toSimpleXml(null, false)->asXML());
    }

    /** @test */
    public function can_have_a_geocode(): void
    {
        $xml = <<<XML
        <OriginAddress>
            <Geocode>
                <Latitude>123456</Latitude>
                <Longitude>654321</Longitude>
            </Geocode>
        </OriginAddress>
        XML;

        $originAddress = OriginAddress::fromXml(new SimpleXMLElement($xml));

        self::assertInstanceOf(Geocode::class, $originAddress->geocode);
        self::assertEquals('123456', $originAddress->geocode->latitude);
        self::assertEquals('654321', $originAddress->geocode->longitude);
    }

    /** @test */
    public function can_render_geocode_to_xml(): void
    {
        $originAddress = new OriginAddress([
            'geocode' => new Geocode([
                'latitude' => '123456',
                'longitude' => '654321',
            ]),
        ]);

        $expectedXml = <<<XML
        <OriginAddress>
            <MaximumListSize>10</MaximumListSize>
            <Geocode>
                <Latitude>123456</Latitude>
                <Longitude>654321</Longitude>
            </Geocode>
        </OriginAddress>
        XML;

        self::assertXmlStringEqualsXmlString(
            $expectedXml,
            $originAddress->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function can_have_custom_list_size(): void
    {
        $originAddress = new OriginAddress(['maximum_list_size' => 5]);

        $expectedXml = <<<XML
        <OriginAddress>
            <MaximumListSize>5</MaximumListSize>
        </OriginAddress>
        XML;

        self::assertXmlStringEqualsXmlString(
            $expectedXml,
            $originAddress->toSimpleXml(null, false)->asXML()
        );
    }
}
