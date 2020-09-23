<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity;

use Rawilk\Ups\Entity\UnitOfMeasurement;
use Rawilk\Ups\Tests\TestCase;

class UnitOfMeasurementTest extends TestCase
{
    /** @test */
    public function code_defaults_to_lbs(): void
    {
        $uom = new UnitOfMeasurement;

        self::assertSame(UnitOfMeasurement::LBS, $uom->code);
    }

    /** @test */
    public function code_can_be_set_in_constructor(): void
    {
        $uom = new UnitOfMeasurement([
            'code' => UnitOfMeasurement::IN,
        ]);

        self::assertNotEquals(UnitOfMeasurement::LBS, $uom->code);
        self::assertSame(UnitOfMeasurement::IN, $uom->code);
    }

    /** @test */
    public function converts_to_xml(): void
    {
        $expectedXml = <<<XML
        <UnitOfMeasurement>
            <Code>LBS</Code>
            <Description>Pounds</Description>
        </UnitOfMeasurement>
        XML;

        $uom = new UnitOfMeasurement([
            'description' => 'Pounds',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expectedXml,
            $uom->toSimpleXml()->asXML()
        );
    }
}
