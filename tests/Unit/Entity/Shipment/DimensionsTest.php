<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\Dimensions;
use Rawilk\Ups\Entity\UnitOfMeasurement;
use Rawilk\Ups\Tests\TestCase;

class DimensionsTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <Dimensions>
            <Length>2</Length>
            <Width>4</Width>
            <Height>5</Height>
            <UnitOfMeasurement>
                <Code>IN</Code>
            </UnitOfMeasurement>
        </Dimensions>
        XML;

        $dimensions = new Dimensions([
            'length' => 2,
            'width' => 4,
            'height' => 5,
            'unit_of_measurement' => new UnitOfMeasurement([
                'code' => UnitOfMeasurement::IN,
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $dimensions->toSimpleXml(null, false)->asXML()
        );
    }
}
