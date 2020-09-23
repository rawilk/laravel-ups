<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\PackageServiceOptions;

use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\AccessPointCOD;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\COD;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\DeliveryConfirmation;

/**
 * @property bool $shipper_release
 * @property bool $ups_premium_care
 * @property null|\Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\DeliveryConfirmation $delivery_confirmation
 * @property null|\Rawilk\Ups\Entity\Shipment\PackageServiceOptions\InsuredValue $insured_value
 * @property null|\Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\COD $cod
 * @property null|\Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\AccessPointCOD $access_point_cod
 * @property null|\Rawilk\Ups\Entity\Shipment\PackageServiceOptions\HazMat|\Rawilk\Ups\Entity\Shipment\PackageServiceOptions\HazMat[] $haz_mat
 *      Max of 3 allowed.
 * @property null|\Rawilk\Ups\Entity\Shipment\PackageServiceOptions\HazMatPackageInformation $haz_mat_package_information
 */
class PackageServiceOptions extends Entity
{
    protected array $attributeKeyMap = [
        'shipper_release_indicator' => 'shipper_release',
        'ups_premium_care_indicator' => 'ups_premium_care',
    ];

    protected $casts = [
        'shipper_release' => 'boolean',
        'ups_premium_care' => 'boolean',
    ];

    public function getShipperReleaseXmlTag(): string
    {
        return 'ShipperReleaseIndicator';
    }

    public function getUpsPremiumCareXmlTag(): string
    {
        return 'UPSPremiumCareIndicator';
    }

    public function accessPointCod(): string
    {
        return AccessPointCOD::class;
    }

    public function cod(): string
    {
        return COD::class;
    }

    public function deliveryConfirmation(): string
    {
        return DeliveryConfirmation::class;
    }

    public function hazMat(): string
    {
        return HazMat::class;
    }

    public function hazMatPackageInformation(): string
    {
        return HazMatPackageInformation::class;
    }

    public function insuredValue(): string
    {
        return InsuredValue::class;
    }
}
