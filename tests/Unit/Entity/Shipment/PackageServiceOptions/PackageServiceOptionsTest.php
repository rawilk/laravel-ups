<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\PackageServiceOptions\PackageServiceOptions;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\DeliveryConfirmation;

it('converts to xml', function () {
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
