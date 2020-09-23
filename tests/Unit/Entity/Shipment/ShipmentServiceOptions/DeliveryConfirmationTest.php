<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\ShipmentServiceOptions;

use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\DeliveryConfirmation;
use Rawilk\Ups\Tests\TestCase;

class DeliveryConfirmationTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <DeliveryConfirmation>
            <DCISType>1</DCISType>
        </DeliveryConfirmation>
        XML;

        $entity = new DeliveryConfirmation([
            'dcis_type' => DeliveryConfirmation::SIGNATURE_REQUIRED,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function can_create_new_instance_with_signature_required(): void
    {
        $expected = <<<XML
        <DeliveryConfirmation>
            <DCISType>1</DCISType>
        </DeliveryConfirmation>
        XML;

        $entity = DeliveryConfirmation::make()->signatureRequired();

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function can_create_new_instance_with_adult_signature_required(): void
    {
        $expected = <<<XML
        <DeliveryConfirmation>
            <DCISType>2</DCISType>
        </DeliveryConfirmation>
        XML;

        $entity = DeliveryConfirmation::make()->adultSignatureRequired();

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
