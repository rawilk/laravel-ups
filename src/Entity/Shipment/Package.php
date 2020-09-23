<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Activity\Activity;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\PackageServiceOptions\PackageServiceOptions;

/**
 * @property bool $additional_handling Additional handling required.
 * @property null|string $description
 *      Merchandise description of package. Required for shipment with return service.
 * @property null|string $pallet_description
 *      Description of articles & special marks. Applicable for Air Freight only.
 * @property bool $is_large
 * @property string $tracking_number
 * @property bool $ups_premium_care_indicator
 * @property null|string $num_of_pieces Applicable for Air Freight only.
 * @property null|string $unit_price Unit price of commodity. Applicable for Air Freight only.
 * @property \Illuminate\Support\Collection|\Rawilk\Ups\Entity\Activity\Activity[] $activities
 * @property null|\Rawilk\Ups\Entity\Shipment\Dimensions $dimensions
 * @property \Rawilk\Ups\Entity\Shipment\PackageServiceOptions\PackageServiceOptions $package_service_options
 * @property \Rawilk\Ups\Entity\Shipment\PackagingType $packaging_type
 * @property \Rawilk\Ups\Entity\Shipment\PackageWeight $package_weight
 * @property \Rawilk\Ups\Entity\Shipment\ReferenceNumber $reference_number
 * @property \Rawilk\Ups\Entity\Shipment\ReferenceNumber $reference_number2
 */
class Package extends Entity
{
    public const OVERSIZE1 = '1';
    public const OVERSIZE2 = '2';
    public const LARGE = '4';

    protected array $attributeKeyMap = [
        'large_package_indicator' => 'is_large_package',
    ];

    protected $casts = [
        'is_large_package' => 'boolean',
    ];

    public function getIsLargePackageXmlTag(): string
    {
        return 'LargePackageIndicator';
    }

    public function activity(): string
    {
        return Activity::class;
    }

    public function dimensions(): string
    {
        return Dimensions::class;
    }

    public function packageServiceOptions(): string
    {
        return PackageServiceOptions::class;
    }

    public function packagingType(): string
    {
        return PackagingType::class;
    }

    public function packageWeight(): string
    {
        return PackageWeight::class;
    }

    public function referenceNumber(): string
    {
        return ReferenceNumber::class;
    }

    public function referenceNumber2(): string
    {
        return ReferenceNumber::class;
    }

    protected function booted(): void
    {
        $relationsToDefault = [
            'package_weight' => $this->packageWeight(),
            'package_service_options' => $this->packageServiceOptions(),
        ];

        foreach ($relationsToDefault as $attribute => $relatedClass) {
            $this->setAttribute($attribute, new $relatedClass);
        }
    }

    /**
     * Convenience method for testing purposes.
     *
     * @return $this
     */
    public function withoutDefaults(): self
    {
        unset($this->package_weight, $this->package_service_options);

        return $this;
    }
}
