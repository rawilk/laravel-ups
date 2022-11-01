<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\ShipmentServiceOptions;

use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\LabelDelivery;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\LabelMethod;
use Rawilk\Ups\Tests\TestCase;

class LabelMethodTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <LabelDelivery>
            <Code>01</Code>
            <Description>foo</Description>
        </LabelDelivery>
        XML;

        $entity = new LabelDelivery([
            'code' => LabelMethod::PRINT_AND_MAIL,
            'description' => 'foo',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function auto_truncates_description(): void
    {
        $description = str_repeat('a', LabelMethod::MAX_DESCRIPTION_LENGTH);
        $tooLong = str_repeat('a', LabelMethod::MAX_DESCRIPTION_LENGTH + 1);

        $expected = <<<XML
        <LabelMethod>
            <Code>01</Code>
            <Description>{$description}</Description>
        </LabelMethod>
        XML;

        $entity = new LabelMethod([
            'code' => LabelMethod::PRINT_AND_MAIL,
            'description' => $tooLong,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
