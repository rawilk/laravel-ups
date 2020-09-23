<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Illuminate\Support\Collection;
use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\ItemizedPaymentInformation;
use Rawilk\Ups\Entity\Payment\PaymentInformation;
use Rawilk\Ups\Entity\Payment\Prepaid;
use Rawilk\Ups\Entity\Shipment\Package;
use Rawilk\Ups\Entity\Shipment\Service;
use Rawilk\Ups\Entity\Shipment\Shipment;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\ShipmentServiceOptions;
use Rawilk\Ups\Tests\TestCase;

class ShipmentTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $serviceCode = Service::DEFAULT_SERVICE_CODE;

        $expected = <<<XML
        <Shipment>
            <Service>
                <Code>{$serviceCode}</Code>
            </Service>
            <ShipmentServiceOptions />
            <Package>
                <PackageWeight>
                    <UnitOfMeasurement>
                        <Code>LBS</Code>
                    </UnitOfMeasurement>
                </PackageWeight>
                <PackageServiceOptions />
            </Package>
            <DocumentsOnlyIndicator />
            <GoodsNotInFreeCirculationIndicator />
            <NumOfPiecesInShipment>3</NumOfPiecesInShipment>
            <RatingMethodRequestedIndicator />
            <TaxInformationIndicator />
            <MasterCartonIndicator />
            <MasterCartonID>1</MasterCartonID>
        </Shipment>
        XML;

        $shipment = new Shipment([
            'packages' => [
                new Package,
            ],
            'documents_only' => true,
            'goods_not_in_free_circulation' => true,
            'num_of_pieces_in_shipment' => 3,
            'rating_method_requested' => true,
            'tax_information' => true,
            'master_carton' => true,
            'master_carton_id' => '1',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $shipment->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function defaults_to_ground_service(): void
    {
        $shipment = new Shipment;

        self::assertInstanceOf(Service::class, $shipment->service);
        self::assertEquals(Service::GROUND, $shipment->service->code);
    }

    /** @test */
    public function initializes_with_empty_service_options_container(): void
    {
        $shipment = new Shipment;

        self::assertInstanceOf(ShipmentServiceOptions::class, $shipment->shipment_service_options);
        self::assertCount(0, $shipment->shipment_service_options->getAttributes());
    }

    /** @test */
    public function omits_itemized_payment_information_if_payment_information_present(): void
    {
        $serviceCode = Service::DEFAULT_SERVICE_CODE;

        $expected = <<<XML
        <Shipment>
            <Service>
                <Code>{$serviceCode}</Code>
            </Service>
            <ShipmentServiceOptions />
            <PaymentInformation>
                <Prepaid>
                    <BillShipper>
                        <AccountNumber>123456</AccountNumber>
                    </BillShipper>
                </Prepaid>
            </PaymentInformation>
        </Shipment>
        XML;

        $shipment = new Shipment([
            'payment_information' => new PaymentInformation([
                'prepaid' => new Prepaid([
                    'bill_shipper' => new BillShipper([
                        'account_number' => '123456',
                    ]),
                ]),
            ]),

            // should be omitted
            'itemized_payment_information' => new ItemizedPaymentInformation,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $shipment->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function packages_is_always_a_collection_instance(): void
    {
        $shipment = new Shipment;

        self::assertInstanceOf(Collection::class, $shipment->packages);
        self::assertCount(0, $shipment->packages);
    }

    /** @test */
    public function can_add_packages_after_initialization(): void
    {
        $shipment = new Shipment([
            'packages' => [
                new Package,
            ],
        ]);

        self::assertCount(1, $shipment->packages);

        $shipment->addPackage(new Package);

        self::assertCount(2, $shipment->packages);

        // Can also add arrays of package data
        $shipment->addPackage(['tracking_number' => '1Z...']);

        self::assertCount(3, $shipment->packages);
        self::assertContainsOnlyInstancesOf(Package::class, $shipment->packages);
        self::assertNull($shipment->packages[0]->tracking_number);
        self::assertEquals('1Z...', $shipment->packages[2]->tracking_number);
    }
}
