<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\PackageServiceOptions;

use Rawilk\Ups\Entity\Shipment\PackageServiceOptions\PackageServiceOptions;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\DeliveryConfirmation;
use Rawilk\Ups\Tests\TestCase;

class PackageServiceOptionsTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <PackageServiceOptions>
            <ShipperReleaseIndicator />
            <UPSPremiumCareIndicator />
            <DeliveryConfirmation>
                <DCISType>1</DCISType>
            </DeliveryConfirmation>
        </PackageServiceOptions>
        XML;

        $entity = new PackageServiceOptions([
            'shipper_release' => true,
            'ups_premium_care' => true,
            'delivery_confirmation' => DeliveryConfirmation::make()->signatureRequired(),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
