<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Shipment\ShipTo;
use Rawilk\Ups\Tests\TestCase;

class ShipToTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <ShipTo>
            <Address>
                <City>foo</City>
            </Address>
            <CompanyName>foo</CompanyName>
            <AttentionName>bar</AttentionName>
            <EMailAddress>email@example.com</EMailAddress>
            <LocationID>foo</LocationID>
        </ShipTo>
        XML;

        $shipTo = new ShipTo([
            'company_name' => 'foo',
            'attention_name' => 'bar',
            'email_address' => 'email@example.com',
            'location_id' => 'foo',
            'address' => new Address([
                'city' => 'foo',
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $shipTo->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function defaults_address_to_new_instance(): void
    {
        $expected = <<<'XML'
        <ShipTo>
            <Address />
        </ShipTo>
        XML;

        $shipTo = new ShipTo;

        self::assertXmlStringEqualsXmlString(
            $expected,
            $shipTo->toSimpleXml(null, false)->asXML()
        );
    }
}
