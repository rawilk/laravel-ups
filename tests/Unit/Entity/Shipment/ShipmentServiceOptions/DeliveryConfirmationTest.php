<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\DeliveryConfirmation;

it('converts to xml', function () {
    $expected = <<<'XML'
    <DeliveryConfirmation>
        <DCISType>1</DCISType>
    </DeliveryConfirmation>
    XML;

    $entity = new DeliveryConfirmation([
        'dcis_type' => DeliveryConfirmation::SIGNATURE_REQUIRED,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('can create a new instance with signature required', function () {
    $expected = <<<'XML'
    <DeliveryConfirmation>
        <DCISType>1</DCISType>
    </DeliveryConfirmation>
    XML;

    $entity = DeliveryConfirmation::make()->signatureRequired();

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('can create a new instance with adult signature required', function () {
    $expected = <<<'XML'
    <DeliveryConfirmation>
        <DCISType>2</DCISType>
    </DeliveryConfirmation>
    XML;

    $entity = DeliveryConfirmation::make()->adultSignatureRequired();

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
