<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions;

use Rawilk\Ups\Entity\Entity;

/**
 * @property bool $saturday_delivery
 *      Saturday delivery indicator. Truthy value indicates Saturday delivery.
 * @property bool $saturday_pickup
 *      Saturday pickup indicator. Truthy value indicates Saturday pickup is required.
 * @property bool $deliver_to_addressee_only
 * @property bool $direct_delivery_only
 * @property bool $return_of_document
 * @property bool $import_control Indicates the shipment is an ImportControl shipment.
 * @property bool $commercial_invoice_removal
 *      Indicates UPS should remove the commercial invoice from the user's shipment before the shipment is delivered ot the ultimate consignee.
 * @property bool $ups_carbonneutral Required to create carbon neutral shipments.
 * @property bool $exchange_forward
 * @property bool $hold_for_pickup
 *      Only valid for UPS Worldwide Express Freight and UPS Worldwide Express Freight Midday shipments.
 * @property bool $dropoff_at_ups_facility
 *      Only valid for UPS Worldwide Express Freight and UPS Worldwide Express Freight Midday shipments.
 * @property bool $lift_gate_for_delivery
 *      Only valid for UPS Worldwide Express Freight and UPS Worldwide Express Freight Midday shipments.
 * @property bool $sdl_shipment
 * @property null|string $epra_release_code
 *      Package release allows the consignee or claimant to pick-up a package at a UPS Access Point.
 * @property null|string $locale
 *      Represents 5 character ISO Locale that allows the user to request Reference Number Code on Label, Label Instructions
 *      and Receipt Instructions (if applicable) in desired language. E.g. en_US
 * @property null|\Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\COD $cod
 *      Indicates COD requested.
 *      Shipment COD is only available from EU origin countries or territories and for shipper's account type
 *      Daily Pickup and Drop Shipping. Not available to shipment with return service.
 * @property null|\Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\AccessPointCOD $access_point_cod
 *      Indicates Access Point COD is requested for a shipment.
 * @property null|\Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\LabelDelivery $label_delivery
 * @property null|\Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\DeliveryConfirmation $delivery_confirmation
 * @property null|\Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\LabelMethod $label_method
 *      Type of ImportControl label.
 */
class ShipmentServiceOptions extends Entity
{
    protected $casts = [
        'saturday_delivery' => 'boolean',
        'saturday_pickup' => 'boolean',
        'deliver_to_addressee_only' => 'boolean',
        'direct_delivery_only' => 'boolean',
        'return_of_document' => 'boolean',
        'import_control' => 'boolean',
        'commercial_invoice_removal' => 'boolean',
        'ups_carbonneutral' => 'boolean',
        'exchange_forward' => 'boolean',
        'hold_for_pickup' => 'boolean',
        'dropoff_at_ups_facility' => 'boolean',
        'lift_gate_for_pickup' => 'boolean',
        'lift_gate_for_delivery' => 'boolean',
        'sdl_shipment' => 'boolean',
    ];

    public function getUpsCarbonneutralXmlTag(): string
    {
        return 'UPSCarbonneutralIndicator';
    }

    public function getCommercialInvoiceRemovalXmlTag(): string
    {
        return 'CommercialInvoiceRemovalIndicator';
    }

    public function getDeliverToAddresseeOnlyXmlTag(): string
    {
        return 'DeliverToAddresseeOnlyIndicator';
    }

    public function getDirectDeliveryOnlyXmlTag(): string
    {
        return 'DirectDeliveryOnlyIndicator';
    }

    public function getDropoffAtUpsFacilityXmlTag(): string
    {
        return 'DropoffAtUPSFacilityIndicator';
    }

    public function getExchangeForwardXmlTag(): string
    {
        return 'ExchangeForwardIndicator';
    }

    public function getEpraReleaseCodeXmlTag(): string
    {
        return 'EPRAReleaseCode';
    }

    public function getImportControlXmlTag(): string
    {
        return 'ImportControlIndicator';
    }

    public function getHoldForPickupXmlTag(): string
    {
        return 'HoldForPickupIndicator';
    }

    public function getLiftGateForPickupXmlTag(): string
    {
        return 'LiftGateForPickupIndicator';
    }

    public function getLiftGateForDeliveryXmlTag(): string
    {
        return 'LiftGateForDeliveryIndicator';
    }

    public function getReturnOfDocumentXmlTag(): string
    {
        return 'ReturnOfDocumentIndicator';
    }

    public function getSaturdayDeliveryXmlTag(): string
    {
        return 'SaturdayDeliveryIndicator';
    }

    public function getSaturdayPickupXmlTag(): string
    {
        return 'SaturdayPickupIndicator';
    }

    public function getSdlShipmentXmlTag(): string
    {
        return 'SDLShipmentIndicator';
    }

    public function accessPointCod(): string
    {
        return AccessPointCOD::class;
    }

    public function cod(): string
    {
        return COD::class;
    }

    public function deliveryConfirmation(): string
    {
        return DeliveryConfirmation::class;
    }

    public function labelDelivery(): string
    {
        return LabelDelivery::class;
    }

    public function labelMethod(): string
    {
        return LabelMethod::class;
    }
}
