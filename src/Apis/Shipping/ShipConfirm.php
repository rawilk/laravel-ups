<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis\Shipping;

use Rawilk\Ups\Apis\Api;
use Rawilk\Ups\Apis\Shipping\Support\ShipConfirmOptions;
use Rawilk\Ups\Entity\Shipment\Label\LabelSpecification;
use Rawilk\Ups\Entity\Shipment\Receipt\ReceiptSpecification;
use Rawilk\Ups\Entity\Shipment\Shipment;
use Rawilk\Ups\Exceptions\BadRequest;
use Rawilk\Ups\Responses\Shipping\ShipConfirmResponse;
use SimpleXMLElement;

/*
 * ShipConfirm generates a shipment digest needed to create a shipment with UPS.
 */
class ShipConfirm extends Api
{
    /** @var string */
    protected const ENDPOINT = '/ShipConfirm';

    protected string $requestOption = ShipConfirmOptions::NON_VALIDATE;

    protected null|Shipment $shipment = null;

    protected null|LabelSpecification $labelSpecification = null;

    protected null|ReceiptSpecification $receiptSpecification = null;

    public function getDigest(): ShipConfirmResponse
    {
        $this->validateRequest();

        return ShipConfirmResponse::fromXml($this->processRequest()->response());
    }

    public function withShipment(Shipment $shipment): self
    {
        $this->shipment = $shipment;

        return $this;
    }

    public function withLabelSpecification(LabelSpecification $labelSpecification): self
    {
        $this->labelSpecification = $labelSpecification;

        return $this;
    }

    public function withReceiptSpecification(ReceiptSpecification $receiptSpecification): self
    {
        $this->receiptSpecification = $receiptSpecification;

        return $this;
    }

    protected function generateRequestXml(): string
    {
        $xml = new SimpleXMLElement('<ShipmentConfirmRequest/>');

        $request = $xml->addChild('Request');
        $request->addChild('RequestAction', 'ShipConfirm');
        $request->addChild('RequestOption', $this->requestOption);
        $this->appendTransactionReference($request);

        $this->shipment->toSimpleXml($xml);

        if ($this->labelSpecification) {
            $this->labelSpecification->toSimpleXml($xml);
        }

        if ($this->receiptSpecification) {
            $this->receiptSpecification->toSimpleXml($xml);
        }

        return (string) $xml->asXML();
    }

    protected function validateRequest(): void
    {
        $this->guardAgainstInvalidShipment();
    }

    protected function guardAgainstInvalidShipment(): void
    {
        if (! $this->shipment) {
            throw BadRequest::missingRequiredData('Shipment is required.');
        }

        if (! $this->shipment->shipper) {
            throw BadRequest::missingRequiredData('Shipper is required on the shipment.');
        }

        if (! $this->shipment->shipper->name) {
            throw BadRequest::missingRequiredData('Shipper name is required.');
        }

        if (! $this->shipment->shipper->shipper_number) {
            throw BadRequest::missingRequiredData('Shipper number is required for this shipment.');
        }

        if (! $this->shipment->shipper->address) {
            throw BadRequest::missingRequiredData('Shipper address is required.');
        }
    }

    /*
     * Convenience methods for request options.
     */

    public function withAddressValidation(): self
    {
        $this->requestOption = ShipConfirmOptions::VALIDATE;

        return $this;
    }

    public function withoutAddressValidation(): self
    {
        $this->requestOption = ShipConfirmOptions::NON_VALIDATE;

        return $this;
    }
}
