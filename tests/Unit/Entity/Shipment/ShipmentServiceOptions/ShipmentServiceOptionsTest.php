<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\DeliveryConfirmation;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\ShipmentServiceOptions;

it('converts to xml', function () {
    $expected = <<<'XML'
    <ShipmentServiceOptions>
        <SaturdayDeliveryIndicator />
        <SaturdayPickupIndicator />
        <DeliverToAddresseeOnlyIndicator />
        <DirectDeliveryOnlyIndicator />
        <ReturnOfDocumentIndicator />
        <CommercialInvoiceRemovalIndicator />
        <UPSCarbonneutralIndicator />
        <ExchangeForwardIndicator />
        <HoldForPickupIndicator />
        <DropoffAtUPSFacilityIndicator />
        <LiftGateForPickupIndicator />
        <LiftGateForDeliveryIndicator />
        <SDLShipmentIndicator />
        <DeliveryConfirmation>
            <DCISType>1</DCISType>
        </DeliveryConfirmation>
    </ShipmentServiceOptions>
    XML;

    $entity = new ShipmentServiceOptions([
        'saturday_delivery' => true,
        'saturday_pickup' => true,
        'deliver_to_addressee_only' => true,
        'direct_delivery_only' => true,
        'return_of_document' => true,
        'commercial_invoice_removal' => true,
        'ups_carbonneutral' => true,
        'exchange_forward' => true,
        'hold_for_pickup' => true,
        'dropoff_at_ups_facility' => true,
        'lift_gate_for_pickup' => true,
        'lift_gate_for_delivery' => true,
        'sdl_shipment' => true,
        'delivery_confirmation' => DeliveryConfirmation::make()->signatureRequired(),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
