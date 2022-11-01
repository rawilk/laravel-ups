<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\AlternateDeliveryAddress;
use Rawilk\Ups\Tests\TestCase;

class AlternateDeliveryAddressTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <AlternateDeliveryAddress>
            <Address />
            <Name>Google</Name>
            <UPSAccessPointID>123</UPSAccessPointID>
        </AlternateDeliveryAddress>
        XML;

        $entity = new AlternateDeliveryAddress([
            'name' => 'Google',
            'ups_access_point_id' => '123',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function truncates_names_that_are_too_long(): void
    {
        $tooLong = str_repeat('a', 36);
        $name = str_repeat('a', 35);

        $expected = <<<XML
        <AlternateDeliveryAddress>
            <Address />
            <Name>{$name}</Name>
        </AlternateDeliveryAddress>
        XML;

        $entity = new AlternateDeliveryAddress([
            'name' => $tooLong,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
