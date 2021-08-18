<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis\Shipping;

use Rawilk\Ups\Apis\Api;
use Rawilk\Ups\Exceptions\BadRequest;
use Rawilk\Ups\Responses\Shipping\ShipAcceptResponse;
use SimpleXMLElement;

/*
 * ShipAccept finalizes a shipment with UPS and requires a shipment digest from ShipConfirm.
 */
class ShipAccept extends Api
{
    /** @var string */
    protected const ENDPOINT = '/ShipAccept';

    protected string $shipmentDigest = '';

    public function createShipment(): ShipAcceptResponse
    {
        $this->validateRequest();

        return ShipAcceptResponse::fromXml($this->processRequest()->response());
    }

    public function usingShipmentDigest(string $shipmentDigest): self
    {
        $this->shipmentDigest = $shipmentDigest;

        return $this;
    }

    protected function generateRequestXml(): string
    {
        $xml = new SimpleXMLElement('<ShipmentAcceptRequest/>');

        $request = $xml->addChild('Request');
        $request->addChild('RequestAction', 'ShipAccept');
        $this->appendTransactionReference($request);

        $xml->addChild('ShipmentDigest', $this->shipmentDigest);

        $search = ['&amp;', '&num;', '&lt;', '&gt;', '&quot;', '&apos;'];
        $replacements = ['&', '#', '<', '>', '"', "'"];

        return str_replace($search, $replacements, $xml->asXML());
    }

    protected function validateRequest(): void
    {
        if (empty($this->shipmentDigest)) {
            throw BadRequest::missingRequiredData('Missing shipment digest to finalize shipment.');
        }
    }
}
