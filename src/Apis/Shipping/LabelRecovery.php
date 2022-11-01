<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis\Shipping;

use Rawilk\Ups\Apis\Api;
use Rawilk\Ups\Entity\Shipment\Label\LabelSpecification;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\LabelDelivery;
use Rawilk\Ups\Entity\Translate;
use Rawilk\Ups\Responses\Shipping\LabelRecoveryResponse;
use SimpleXMLElement;

class LabelRecovery extends Api
{
    /** @var string */
    protected const ENDPOINT = '/LabelRecovery';

    protected null|LabelSpecification $labelSpecification = null;

    protected null|Translate $translate = null;

    protected null|LabelDelivery $labelDelivery = null;

    protected string $trackingNumber = '';

    public function recover(): LabelRecoveryResponse
    {
        return LabelRecoveryResponse::fromXml($this->processRequest()->response());
    }

    public function withLabelSpecification(LabelSpecification $labelSpecification): self
    {
        $this->labelSpecification = $labelSpecification;

        return $this;
    }

    public function withTranslate(Translate $translate): self
    {
        $this->translate = $translate;

        return $this;
    }

    public function withLabelDelivery(LabelDelivery $labelDelivery): self
    {
        $this->labelDelivery = $labelDelivery;

        return $this;
    }

    public function withTrackingNumber(string $trackingNumber): self
    {
        $this->trackingNumber = $trackingNumber;

        return $this;
    }

    protected function generateRequestXml(): string
    {
        $xml = new SimpleXMLElement('<LabelRecoveryRequest/>');

        $request = $xml->addChild('Request');
        $request->addChild('RequestAction', 'LabelRecovery');
        $this->appendTransactionReference($request);

        if ($this->trackingNumber) {
            $xml->addChild('TrackingNumber', $this->trackingNumber);
        }

        if ($this->labelSpecification) {
            $this->labelSpecification->toSimpleXml($xml);
        }

        if ($this->translate) {
            $this->translate->toSimpleXml($xml);
        }

        if ($this->labelDelivery) {
            $this->labelDelivery->toSimpleXml($xml);
        }

        return (string) $xml->asXML();
    }
}
