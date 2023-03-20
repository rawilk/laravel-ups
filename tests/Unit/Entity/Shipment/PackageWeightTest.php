<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\PackageWeight;
use Rawilk\Ups\Entity\UnitOfMeasurement;
use Rawilk\Ups\Tests\TestCase;

class PackageWeightTest extends TestCase
{
    /** @test */
    public function uom_defaults_to_lbs(): void
    {
        $expected = <<<'XML'
        <PackageWeight>
            <UnitOfMeasurement>
                <Code>LBS</Code>
            </UnitOfMeasurement>
            <Weight>3</Weight>
        </PackageWeight>
        XML;

        $weight = new PackageWeight([
            'weight' => '3',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $weight->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function uom_can_be_customized(): void
    {
        $expected = <<<'XML'
        <PackageWeight>
            <UnitOfMeasurement>
                <Code>KGS</Code>
            </UnitOfMeasurement>
            <Weight>3</Weight>
        </PackageWeight>
        XML;

        $weight = new PackageWeight([
            'weight' => '3',
            'unit_of_measurement' => new UnitOfMeasurement([
                'code' => UnitOfMeasurement::KGS,
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $weight->toSimpleXml(null, false)->asXML()
        );
    }
}
