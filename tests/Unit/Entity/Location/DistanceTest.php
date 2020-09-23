<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Location;

use Rawilk\Ups\Entity\Location\Distance;
use Rawilk\Ups\Entity\UnitOfMeasurement;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class DistanceTest extends TestCase
{
    /** @test */
    public function can_be_created_from_xml(): void
    {
        $xml = <<<XML
        <Distance>
            <Value>2</Value>
            <UnitOfMeasurement>
                <Code>MI</Code>
            </UnitOfMeasurement>
        </Distance>
        XML;

        $distance = Distance::fromXml(new SimpleXMLElement($xml));

        self::assertIsFloat($distance->value);
        self::assertEquals(2, $distance->value);
        self::assertInstanceOf(UnitOfMeasurement::class, $distance->unit_of_measurement);
        self::assertSame('MI', $distance->unit_of_measurement->code);
    }

    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <Distance>
            <Value>2</Value>
            <UnitOfMeasurement>
                <Code>MI</Code>
            </UnitOfMeasurement>
        </Distance>
        XML;

        $distance = new Distance([
            'value' => 2,
            'unit_of_measurement' => new UnitOfMeasurement([
                'code' => 'MI',
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $distance->toSimpleXml(null, false)->asXML()
        );
    }
}
