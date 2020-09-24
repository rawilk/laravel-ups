<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Apis\Shipping;

use Rawilk\Ups\Apis\Shipping\ShipConfirm;
use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\PaymentInformation;
use Rawilk\Ups\Entity\Payment\Prepaid;
use Rawilk\Ups\Entity\Payment\RateInformation;
use Rawilk\Ups\Entity\Shipment\Label\LabelSpecification;
use Rawilk\Ups\Entity\Shipment\Package;
use Rawilk\Ups\Entity\Shipment\PackageWeight;
use Rawilk\Ups\Entity\Shipment\PackagingType;
use Rawilk\Ups\Entity\Shipment\ReferenceNumber;
use Rawilk\Ups\Entity\Shipment\ShipFrom;
use Rawilk\Ups\Entity\Shipment\Shipment;
use Rawilk\Ups\Entity\Shipment\Shipper;
use Rawilk\Ups\Entity\Shipment\ShipTo;
use Rawilk\Ups\Exceptions\BadRequest;
use Rawilk\Ups\Tests\TestCase;

class ShipConfirmTest extends TestCase
{
    /** @test */
    public function can_make_api_requests(): void
    {
        $account = $this->app['config']['ups.shipper_number'];

        $shipment = new Shipment([
            'shipper' => new Shipper([
                'shipper_number' => $account,
                'name' => 'Shipper Name',
                'address' => new Address([
                    'address_line1' => '1401 E Main St',
                    'city' => 'Merrill',
                    'state' => 'WI',
                    'postal_code' => '54452',
                    'country_code' => 'US',
                ]),
            ]),

            'ship_to' => new ShipTo([
                'company_name' => 'Ship To Company Name',
                'attention_name' => 'Ship To Attn Name',
                'address' => new Address([
                    'address_line1' => '5017 N 28th Ave',
                    'city' => 'Wausau',
                    'state' => 'WI',
                    'postal_code' => '54401',
                    'country_code' => 'US',
                    'residential' => true,
                ]),
            ]),

            'ship_from' => new ShipFrom([
                'company_name' => 'Ship From Company Name',
                'attention_name' => 'Ship From Attn Name',
                'address' => new Address([
                    'address_line1' => '1401 E Main St',
                    'city' => 'Merrill',
                    'state' => 'WI',
                    'postal_code' => '54452',
                    'country_code' => 'US',
                ]),
            ]),

            'description' => 'Shipment description',

            'payment_information' => new PaymentInformation([
                'prepaid' => new Prepaid([
                    'bill_shipper' => new BillShipper([
                        'account_number' => $account,
                    ]),
                ]),
            ]),

            'packages' => [
                new Package([
                    'packaging_type' => new PackagingType, // Customer supplied package
                    'description' => 'Package description',
                    'reference_number' => new ReferenceNumber([
                        'value' => 'Package',
                    ]),
                    'package_weight' => new PackageWeight([
                        'weight' => '60.0',
                    ]),
                    'is_large_package' => true,
                ]),
            ],
        ]);

        if ($this->app['config']['ups.negotiated_rates']) {
            $shipment->rate_information = new RateInformation([
                'negotiated_rates' => true,
            ]);
        }

        $response = (new ShipConfirm)
            ->withShipment($shipment)
            ->withLabelSpecification(LabelSpecification::asGIF())
            ->getDigest();

        self::assertNotEmpty($response->shipment_identification_number);
        self::assertNotEmpty($response->shipment_digest);
    }

    /** @test */
    public function shipment_is_required(): void
    {
        $this->expectException(BadRequest::class);

        (new ShipConfirm)->getDigest();
    }

    /** @test */
    public function shipper_is_required(): void
    {
        $this->expectException(BadRequest::class);

        $shipment = new Shipment;

        (new ShipConfirm)->withShipment($shipment)->getDigest();
    }

    /** @test */
    public function shipper_name_is_required(): void
    {
        $this->expectException(BadRequest::class);

        $shipment = new Shipment([
            'shipper' => new Shipper,
        ]);

        (new ShipConfirm)->withShipment($shipment)->getDigest();
    }

    /** @test */
    public function shipper_number_is_required(): void
    {
        $this->expectException(BadRequest::class);

        $shipment = new Shipment([
            'shipper' => new Shipper([
                'name' => 'foo',
            ]),
        ]);

        (new ShipConfirm)->withShipment($shipment)->getDigest();
    }

    /** @test */
    public function shipper_address_is_required(): void
    {
        $this->expectException(BadRequest::class);

        $shipment = new Shipment([
            'shipper' => new Shipper([
                'name' => 'foo',
                'shipper_number' => '123456',
            ]),
        ]);

        (new ShipConfirm)->withShipment($shipment)->getDigest();
    }
}
