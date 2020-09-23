<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\BillingWeight;
use Rawilk\Ups\Entity\UnitOfMeasurement;
use Rawilk\Ups\Tests\TestCase;

class BillingWeightTest extends TestCase
{
    /** @test */
    public function uom_defaults_to_lbs(): void
    {
        $expected = <<<XML
        <BillingWeight>
            <UnitOfMeasurement>
                <Code>LBS</Code>
            </UnitOfMeasurement>
            <Weight>3</Weight>
        </BillingWeight>
        XML;

        $entity = new BillingWeight([
            'weight' => '3',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function uom_can_be_customized(): void
    {
        $expected = <<<XML
        <BillingWeight>
            <UnitOfMeasurement>
                <Code>KGS</Code>
            </UnitOfMeasurement>
            <Weight>3</Weight>
        </BillingWeight>
        XML;

        $entity = new BillingWeight([
            'weight' => '3',
            'unit_of_measurement' => new UnitOfMeasurement([
                'code' => UnitOfMeasurement::KGS,
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
