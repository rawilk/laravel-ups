<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Shipment\Shipper;
use Rawilk\Ups\Exceptions\InvalidAttribute;
use Rawilk\Ups\Tests\TestCase;

class ShipperTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <Shipper>
            <Name>foo</Name>
            <AttentionName>foo</AttentionName>
            <CompanyDisplayableName>Foo</CompanyDisplayableName>
            <ShipperNumber>123456</ShipperNumber>
            <Address>
                <City>foo</City>
            </Address>
        </Shipper>
        XML;

        $shipper = new Shipper([
            'name' => 'foo',
            'attention_name' => 'foo',
            'company_displayable_name' => 'Foo',
            'shipper_number' => '123456',
            'address' => new Address([
                'city' => 'foo',
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $shipper->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function auto_truncates_names(): void
    {
        $name = str_repeat('a', Shipper::MAX_NAME_LENGTH);
        $tooLong = str_repeat('a', Shipper::MAX_NAME_LENGTH + 1);

        $expected = <<<XML
        <Shipper>
            <Name>{$name}</Name>
            <AttentionName>{$name}</AttentionName>
            <CompanyDisplayableName>{$name}</CompanyDisplayableName>
        </Shipper>
        XML;

        $shipper = new Shipper([
            'name' => $tooLong,
            'attention_name' => $tooLong,
            'company_displayable_name' => $tooLong,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $shipper->toSimpleXml(null, false)->asXML()
        );
    }

    /**
     * @test
     * @dataProvider invalidShipperNumbers
     * @param string $shipperNumber
     */
    public function throws_an_exception_for_invalid_shipper_numbers(string $shipperNumber): void
    {
        $this->expectException(InvalidAttribute::class);

        new Shipper([
            'shipper_number' => $shipperNumber,
        ]);
    }

    public function invalidShipperNumbers(): array
    {
        return [
            [''],
            [str_repeat('1', Shipper::SHIPPER_NUMBER_LENGTH - 1)],
            [str_repeat('1', Shipper::SHIPPER_NUMBER_LENGTH + 1)],
        ];
    }
}
