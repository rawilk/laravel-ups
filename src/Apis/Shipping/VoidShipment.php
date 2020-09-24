<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis\Shipping;

use Illuminate\Support\Str;
use Rawilk\Ups\Apis\Api;
use Rawilk\Ups\Exceptions\BadRequest;
use Rawilk\Ups\Responses\Shipping\VoidResponse;
use SimpleXMLElement;

class VoidShipment extends Api
{
    /** @var string */
    protected const ENDPOINT = '/Void';

    protected string $shipmentIdentificationNumber = '';

    /*
     * Tracking numbers of individual packages to void instead of the entire shipment.
     */
    protected array $trackingNumbers = [];

    public function usingShipmentIdentificationNumber(string $id): self
    {
        $this->shipmentIdentificationNumber = $id;

        return $this;
    }

    public function usingTrackingNumbers(array $trackingNumbers): self
    {
        $this->trackingNumbers = $trackingNumbers;

        return $this;
    }

    public function void(): VoidResponse
    {
        $this->validate();

        return VoidResponse::fromXml(
            $this
                    ->allowRequestErrors()
                    ->processRequest()
                    ->response()
        );
    }

    protected function generateRequestXml(): string
    {
        $xml = new SimpleXMLElement('<VoidShipmentRequest/>');

        $request = $xml->addChild('Request');
        $request->addChild('RequestAction', '1');
        $this->appendTransactionReference($request);

        if ($this->isVoidingEntireShipment()) {
            $xml->addChild('ShipmentIdentificationNumber', $this->shipmentIdentificationNumber);
        } else {
            $expanded = $xml->addChild('ExpandedVoidShipment');

            $expanded->addChild('ShipmentIdentificationNumber', $this->shipmentIdentificationNumber);

            foreach ($this->trackingNumbers as $trackingNumber) {
                $expanded->addChild('TrackingNumber', $trackingNumber);
            }
        }

        return (string) $xml->asXML();
    }

    protected function isVoidingEntireShipment(): bool
    {
        return empty($this->trackingNumbers);
    }

    protected function validate(): void
    {
        $this->guardAgainstInvalidShipmentId();

        $this->guardAgainstInvalidTrackingNumbers();
    }

    protected function guardAgainstInvalidShipmentId(): void
    {
        if (empty($this->shipmentIdentificationNumber)) {
            throw BadRequest::missingRequiredData('Missing shipment identification number.');
        }

        // The ID number must be a 1Z number and be all uppercase.
        if (! $this->isValid1ZNumber($this->shipmentIdentificationNumber)) {
            throw BadRequest::invalidData('Shipment identification number is not valid');
        }
    }

    protected function guardAgainstInvalidTrackingNumbers(): void
    {
        if (empty($this->trackingNumbers)) {
            return;
        }

        foreach ($this->trackingNumbers as $trackingNumber) {
            if (! $this->isValid1ZNumber($trackingNumber)) {
                throw BadRequest::invalidData("Invalid tracking number: {$trackingNumber}");
            }
        }
    }

    protected function isValid1ZNumber(string $number): bool
    {
        return Str::startsWith($number, '1Z')
            && strtoupper($number) === $number
            && $number !== '1Z';
    }
}
