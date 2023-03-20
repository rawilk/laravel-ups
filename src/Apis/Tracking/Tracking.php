<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis\Tracking;

use Rawilk\Ups\Apis\Api;
use Rawilk\Ups\Entity\Shipment\ShipmentType;
use Rawilk\Ups\Exceptions\BadRequest;
use Rawilk\Ups\Responses\Tracking\TrackingResponse;
use SimpleXMLElement;

class Tracking extends Api
{
    /** @var string */
    protected const ENDPOINT = '/Track';

    protected string $requestOption = TrackingOptions::ALL_ACTIVITY;

    protected string $trackingNumber = '';

    protected string $shipmentIdentificationNumber = '';

    protected string $referenceNumber = '';

    protected $shipperNumber = '';

    protected string $shipmentType = ShipmentType::PACKAGE;

    public function track(): TrackingResponse
    {
        $this->validate();

        $this->allowRequestErrors();

        return TrackingResponse::fromXml($this->processRequest()->response());
    }

    public function requestOption(string $option): self
    {
        $this->requestOption = $option;

        return $this;
    }

    public function usingTrackingNumber(string $trackingNumber): self
    {
        $this->trackingNumber = $trackingNumber;

        return $this;
    }

    public function usingShipmentIdentificationNumber(string $id): self
    {
        $this->shipmentIdentificationNumber = $id;

        return $this;
    }

    public function usingReferenceNumber(string $referenceNumber): self
    {
        $this->referenceNumber = $referenceNumber;

        return $this;
    }

    public function usingShipperNumber(string $shipperNumber): self
    {
        $this->shipperNumber = $shipperNumber;

        return $this;
    }

    public function usingShipmentType(string $shipmentType): self
    {
        $this->shipmentType = $shipmentType;

        return $this;
    }

    protected function generateRequestXml(): string
    {
        $xml = new SimpleXMLElement('<TrackRequest/>');

        $request = $xml->addChild('Request');
        $this->appendTransactionReference($request);
        $request->addChild('RequestAction', 'Track');
        $request->addChild('RequestOption', $this->requestOption);

        if ($this->trackingNumber) {
            $xml->addChild('TrackingNumber', $this->trackingNumber);
        }

        if ($this->shipmentIdentificationNumber) {
            $xml->addChild('ShipmentIdentificationNumber', $this->shipmentIdentificationNumber);
        }

        if ($this->referenceNumber) {
            $referenceNumber = $xml->addChild('ReferenceNumber');
            $referenceNumber->addChild('Value', $this->referenceNumber);

            $this->appendShipmentType($xml);
        }

        if ($this->shipperNumber) {
            $xml->addChild('ShipperNumber', $this->shipperNumber);
        }

        if ($this->isMailInnovations()) {
            $xml->addChild('IncludeMailInnovationIndicator');
        }

        return (string) $xml->asXML();
    }

    protected function validate(): void
    {
        $this->ensureIdentificationMethodSet();
    }

    protected function ensureIdentificationMethodSet(): void
    {
        if (! $this->trackingNumber && ! $this->shipmentIdentificationNumber && ! $this->referenceNumber) {
            throw BadRequest::missingRequiredData('You must include either a tracking number, shipment identification number, or reference number.');
        }

        if ($this->referenceNumber && ! in_array($this->shipmentType, [ShipmentType::PACKAGE, ShipmentType::FREIGHT, ShipmentType::MAIL_INNOVATIONS], true)) {
            throw BadRequest::invalidData('Invalid shipment type.');
        }
    }

    protected function appendShipmentType(SimpleXMLElement $parent): void
    {
        $shipmentType = new ShipmentType(['code' => $this->shipmentType]);

        $shipmentType->toSimpleXml($parent);
    }

    protected function isMailInnovations(): bool
    {
        $patterns = [
            // UPS Mail Innovations tracking numbers
            '/^MI\d{6}\d{1,22}$/', // MI 000000 00000000+

            // USPS - Certified Mail
            '/^94071\d{17}$/',    // 9407 1000 0000 0000 0000 00
            '/^7\d{19}$/',        // 7000 0000 0000 0000 0000

            // USPS - Collect on Delivery
            '/^93033\d{17}$/',    // 9303 3000 0000 0000 0000 00
            '/^M\d{9}$/',         // M000 0000 00

            // USPS - Global Express Guaranteed
            '/^82\d{10}$/',       // 82 000 000 00

            // USPS - Priority Mail Express International
            '/^EC\d{9}US$/',      // EC 000 000 000 US

            // USPS Innovations Expedited
            '/^927\d{23}$/',      // 9270 8900 8900 8900 8900 8900 00

            // USPS - Priority Mail Express
            '/^927\d{19}$/',      // 9270 1000 0000 0000 0000 00
            '/^EA\d{9}US$/',      // EA 000 000 000 US

            // USPS - Priority Mail International
            '/^CP\d{9}US$/',      // CP 000 000 000 US

            // USPS - Priority Mail
            '/^92055\d{17}$/',    // 9205 5000 0000 0000 0000 00
            '/^14\d{18}$/',       // 1400 0000 0000 0000 0000

            // USPS - Registered Mail
            '/^92088\d{17}$/',    // 9208 8000 0000 0000 0000 00
            '/^RA\d{9}US$/',      // RA 000 000 000 US

            // USPS - Signature Confirmation
            '/^9202\d{16}US$/',   // 9202 1000 0000 0000 0000 00
            '/^23\d{16}US$/',     // 2300 0000 0000 0000 0000

            // USPS - Tracking
            '/^94\d{20}$/',       // 9400 1000 0000 0000 0000 00
            '/^03\d{18}$/',        // 0300 0000 0000 0000 0000
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->trackingNumber)) {
                return true;
            }
        }

        return false;
    }

    /*
     * Convenience methods for tracking options.
     */

    public function lastActivity(): self
    {
        $this->requestOption = TrackingOptions::LAST_ACTIVITY;

        return $this;
    }

    public function allActivity(): self
    {
        $this->requestOption = TrackingOptions::ALL_ACTIVITY;

        return $this;
    }
}
