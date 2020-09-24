<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Payment\InvoiceLineTotal;
use Rawilk\Ups\Entity\Payment\ItemizedPaymentInformation;
use Rawilk\Ups\Entity\Payment\PaymentInformation;
use Rawilk\Ups\Entity\Payment\PromotionalDiscountInformation;
use Rawilk\Ups\Entity\Payment\RateInformation;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\ShipmentServiceOptions;

/**
 * @property null|string $description
 *      The description of Goods for the shipment. Applies to international and domestic shipments.
 * @property bool $documents_only
 *      Indicates a shipment contains written typed, or printed communication of no commercial value.
 * @property bool $goods_not_in_free_circulation
 * @property null|int $num_of_pieces_in_shipment
 *      Total number of pieces in all pallets in a UPS World Wide Express Freight Shipment.
 * @property bool $rating_method_requested
 *      If true, Billable Weight Collection information and Rating Method information would be returned
 *      in response.
 * @property bool $tax_information
 *      If true, any taxes that may be applicable to a shipment would be returned in a response.
 * @property bool $master_carton
 * @property null|string $master_carton_id
 * @property null|\Rawilk\Ups\Entity\Shipment\ReturnService $return_service
 *      Type of return service. When this entity is present, the shipment is a return shipment.
 * @property \Rawilk\Ups\Entity\Shipment\Shipper $shipper
 *      Container for the shipper's information.
 * @property \Rawilk\Ups\Entity\Shipment\ShipTo $ship_to
 * @property \Rawilk\Ups\Entity\Shipment\ShipFrom $ship_from
 *      Required for return shipment or if pickup location is different than the shipper's address.
 * @property null|\Rawilk\Ups\Entity\Shipment\SoldTo $sold_to
 * @property null|\Rawilk\Ups\Entity\Payment\PaymentInformation $payment_information
 * @property null|\Rawilk\Ups\Entity\Payment\ItemizedPaymentInformation $itemized_payment_information
 * @property null|\Rawilk\Ups\Entity\Payment\PromotionalDiscountInformation $promotional_discount_information
 * @property null|\Rawilk\Ups\Entity\Payment\RateInformation $rate_information
 * @property \Rawilk\Ups\Entity\Shipment\Service $service
 * @property \Rawilk\Ups\Entity\Payment\InvoiceLineTotal $invoice_line_total
 * @property \Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\ShipmentServiceOptions $shipment_service_options
 * @property \Illuminate\Support\Collection|\Rawilk\Ups\Entity\Shipment\Package[] $packages
 * @property null|\Rawilk\Ups\Entity\Shipment\ShipmentIndicationType $shipment_indication_type
 */
class Shipment extends Entity
{
    protected array $attributeKeyMap = [
        'rating_method_requested_indicator' => 'rating_method_requested',
        'goods_not_in_free_circulation_indicator' => 'goods_not_in_free_circulation',
        'tax_information_indicator' => 'tax_information',
        'master_carton_indicator' => 'master_carton',
    ];

    protected $casts = [
        'documents_only' => 'boolean',
        'goods_not_in_free_circulation' => 'boolean',
        'num_of_pieces_in_shipment' => 'integer',
        'rating_method_requested' => 'boolean',
        'tax_information' => 'boolean',
        'master_carton' => 'boolean',
    ];

    protected function booted(): void
    {
        // In most cases we'll just want to  use a default service (GROUND).
        // We'll just default it to that for convenience.
        $this->setAttribute('service', new Service);

        // Let's default the shipment service options to an empty container.
        $this->setAttribute('shipment_service_options', new ShipmentServiceOptions);
    }

    protected function startingSimpleXml(): void
    {
        // Only one may be present in the request.
        if ($this->payment_information) {
            unset($this->itemized_payment_information);
        }
    }

    public function getDocumentsOnlyXmlTag(): string
    {
        return 'DocumentsOnlyIndicator';
    }

    public function getGoodsNotInFreeCirculationXmlTag(): string
    {
        return 'GoodsNotInFreeCirculationIndicator';
    }

    public function getMasterCartonXmlTag(): string
    {
        return 'MasterCartonIndicator';
    }

    public function getMasterCartonIdXmlTag(): string
    {
        return 'MasterCartonID';
    }

    public function getRatingMethodRequestedXmlTag(): string
    {
        return 'RatingMethodRequestedIndicator';
    }

    public function getTaxInformationXmlTag(): string
    {
        return 'TaxInformationIndicator';
    }

    public function getPackagesXmlTag(): string
    {
        return 'Package';
    }

    public function invoiceLineTotal(): string
    {
        return InvoiceLineTotal::class;
    }

    public function itemizedPaymentInformation(): string
    {
        return ItemizedPaymentInformation::class;
    }

    public function package(): string
    {
        return Package::class;
    }

    public function paymentInformation(): string
    {
        return PaymentInformation::class;
    }

    public function promotionalDiscountInformation(): string
    {
        return PromotionalDiscountInformation::class;
    }

    public function rateInformation(): string
    {
        return RateInformation::class;
    }

    public function returnService(): string
    {
        return ReturnService::class;
    }

    public function service(): string
    {
        return Service::class;
    }

    public function shipper(): string
    {
        return Shipper::class;
    }

    public function shipmentIndicationType(): string
    {
        return ShipmentIndicationType::class;
    }

    public function shipTo(): string
    {
        return ShipTo::class;
    }

    public function shipFrom(): string
    {
        return ShipFrom::class;
    }

    public function shipmentServiceOptions(): string
    {
        return ShipmentServiceOptions::class;
    }

    public function soldTo(): string
    {
        return SoldTo::class;
    }

    public function getPackagesAttribute($packages): Collection
    {
        if (is_null($packages)) {
            return collect();
        }

        if (! is_array($packages)) {
            $packages = [$packages];
        }

        return collect($packages)
            ->flatten()
            ->map(fn ($package) => $package instanceof Package ? $package : new Package($package));
    }

    public function addPackage($package): self
    {
        if (! $package instanceof Package && is_array($package)) {
            $package = new Package($package);
        }

        if (! $package instanceof Package) {
            throw new InvalidArgumentException('$package must be an instance of ' . Package::class);
        }

        $this->packages = $this->packages->push($package);

        return $this;
    }
}
