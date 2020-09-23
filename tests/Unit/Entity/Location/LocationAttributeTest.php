<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Rawilk\Ups\Entity\Location\LocationAttribute;
use Rawilk\Ups\Entity\Location\OptionCode;
use Rawilk\Ups\Entity\Location\OptionType;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class LocationAttributeTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<XML
        <LocationAttribute>
            <OptionCode>
                <Category>foo</Category>
                <Code>02</Code>
                <Name>Retail</Name>
            </OptionCode>
            <OptionType>
                <Code>02</Code>
                <Description>RETAIL LOCATION</Description>
            </OptionType>
        </LocationAttribute>
        XML;

        $entity = LocationAttribute::fromXml(new SimpleXMLElement($xml));

        self::assertInstanceOf(OptionCode::class, $entity->option_code);
        self::assertSame('foo', $entity->option_code->category);
        self::assertSame('02', $entity->option_code->code);
        self::assertSame('Retail', $entity->option_code->name);

        self::assertInstanceOf(OptionType::class, $entity->option_type);
        self::assertSame('02', $entity->option_type->code);
        self::assertSame('RETAIL LOCATION', $entity->option_type->description);
    }

    /** @test */
    public function can_have_many_option_codes(): void
    {
        $xml = <<<XML
        <LocationAttribute>
            <OptionCode>
                <Code>02</Code>
                <Name>International Shipping Expert</Name>
            </OptionCode>
            <OptionCode>
                <Code>04</Code>
                <Name>Apple Returns Program</Name>
            </OptionCode>
        </LocationAttribute>
        XML;

        $entity = LocationAttribute::fromXml(new SimpleXMLElement($xml));

        self::assertIsArray($entity->option_code);
        self::assertCount(2, $entity->option_code);

        self::assertEquals('02', $entity->option_code[0]->code);
        self::assertEquals('International Shipping Expert', $entity->option_code[0]->name);

        self::assertEquals('04', $entity->option_code[1]->code);
        self::assertEquals('Apple Returns Program', $entity->option_code[1]->name);
    }
}
