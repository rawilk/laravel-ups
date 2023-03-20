<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\AddressValidation;

use Rawilk\Ups\Entity\AddressValidation\AddressClassification;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class AddressClassificationTest extends TestCase
{
    /** @test */
    public function code_is_integer(): void
    {
        $entity = new AddressClassification(['code' => '2']);

        self::assertIsInt($entity->code);
        self::assertSame(2, $entity->code);
    }

    /** @test */
    public function converts_to_simple_xml(): void
    {
        $expected = <<<'XML'
        <AddressClassification>
            <Code>1</Code>
            <Description>Commercial</Description>
        </AddressClassification>
        XML;

        $entity = new AddressClassification([
            'code' => AddressClassification::COMMERCIAL,
            'description' => 'Commercial',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<'XML'
        <AddressClassification>
            <Code>1</Code>
            <Description>Commercial</Description>
        </AddressClassification>
        XML;

        $entity = AddressClassification::fromXml(new SimpleXMLElement($xml));

        $expected = [
            'code' => 1,
            'description' => 'Commercial',
        ];

        self::assertEquals($expected, $entity->toArray());
    }
}
