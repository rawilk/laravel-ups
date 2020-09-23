<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Address;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Tests\Concerns\UsesFilesystem;
use Rawilk\Ups\Tests\TestCase;

class AddressTest extends TestCase
{
    use UsesFilesystem;

    /** @test */
    public function can_convert_to_xml(): void
    {
        $expectedXml = $this->getXmlContent('address')->asXML();

        $address = new Address([
            'address_line1' => '7510 AIRWAY RD',
            'address_line2' => 'STE 7',
            'city' => 'SAN DIEGO',
            'state' => 'CA',
            'postal_code' => '92154',
            'country_code' => 'US',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expectedXml,
            $address->toSimpleXml()->asXML()
        );
    }

    /** @test */
    public function can_convert_to_xml_for_validation(): void
    {
        $expectedXml = $this->getXmlContent('address-for-validation')->asXML();

        $address = new Address([
            'address_line1' => '7510 AIRWAY RD',
            'address_line2' => 'STE 7',
            'city' => 'SAN DIEGO',
            'state' => 'CA',
            'postal_code' => '92154',
            'country_code' => 'US',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expectedXml,
            $address->isForValidation()->toSimpleXml()->asXML()
        );
    }

    /** @test */
    public function residential_is_boolean(): void
    {
        $address = new Address([
            'residential' => 1,
        ]);

        self::assertIsBool($address->residential);
        self::assertTrue($address->residential);
    }

    /** @test */
    public function residential_is_omitted_in_the_xml_when_it_is_false(): void
    {
        $expectedXml = <<<XML
        <Address>
            <City>Foo</City>
        </Address>
        XML;

        $address = new Address([
            'city' => 'Foo',
            'residential' => false,
        ]);

        self::assertXmlStringEqualsXmlString($expectedXml, $address->toSimpleXml(null, false)->asXML());
    }

    /** @test */
    public function residential_is_included_as_a_self_closing_empty_tag_in_xml_when_it_is_true(): void
    {
        $expectedXml = <<<XML
        <Address>
            <City>Foo</City>
            <ResidentialAddress />
        </Address>
        XML;

        $address = new Address([
            'city' => 'Foo',
            'residential' => true,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expectedXml,
            $address->toSimpleXml(null, false)->asXML()
        );
    }
}
