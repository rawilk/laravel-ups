<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\ShipmentServiceOptions;

use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\LabelDelivery;
use Rawilk\Ups\Tests\TestCase;

class LabelDeliveryTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <LabelDelivery>
            <LabelLinksIndicator />
        </LabelDelivery>
        XML;

        $entity = new LabelDelivery([
            'label_links' => true,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
