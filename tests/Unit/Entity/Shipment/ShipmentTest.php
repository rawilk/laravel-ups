<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\ItemizedPaymentInformation;
use Rawilk\Ups\Entity\Payment\PaymentInformation;
use Rawilk\Ups\Entity\Payment\Prepaid;
use Rawilk\Ups\Entity\Shipment\Package;
use Rawilk\Ups\Entity\Shipment\Service;
use Rawilk\Ups\Entity\Shipment\Shipment;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\ShipmentServiceOptions;

it('converts to xml', function () {
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $shipment->toSimpleXml(null, false)->asXML(),
    );
});

it('defaults to ground service', function () {
    $shipment = new Shipment;

    expect($shipment->service)->toBeInstanceOf(Service::class)
        ->and($shipment->service->code)->toBe(Service::GROUND);
});

it('initializes with empty service options container', function () {
    $shipment = new Shipment;

    expect($shipment->shipment_service_options)->toBeInstanceOf(ShipmentServiceOptions::class)
        ->and($shipment->shipment_service_options->getAttributes())->toHaveCount(0);
});

it('omits itemized payment information element if payment information is present', function () {
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $shipment->toSimpleXml(null, false)->asXML(),
    );
});

test('packages is always a collection instance', function () {
    $shipment = new Shipment;

    expect($shipment->packages)->toBeInstanceOf(Collection::class)
        ->and($shipment->packages)->count()->toBe(0);
});

it('can add packages after initialization', function () {
    $shipment = new Shipment([
        'packages' => [
            new Package,
        ],
    ]);

    expect($shipment->packages)->count()->toBe(1);

    $shipment->addPackage(new Package);

    expect($shipment->packages)->count()->toBe(2);

    // Can also add arrays of package data.
    $shipment->addPackage(['tracking_number' => '1Z...']);

    expect($shipment->packages)->count()->toBe(3)
        ->and($shipment->packages[0]->tracking_number)->toBeNull()
        ->and($shipment->packages[2]->tracking_number)->toBe('1Z...');

    $this->assertContainsOnlyInstancesOf(Package::class, $shipment->packages);
});
