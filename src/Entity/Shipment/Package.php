<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Illuminate\Support\Collection;
use Rawilk\Ups\Entity\Activity\Activity;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\PackageServiceOptions\PackageServiceOptions;
use Rawilk\Ups\Entity\Tracking\EstimatedDeliveryWindow;

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
 * @property null|\Rawilk\Ups\Entity\Tracking\EstimatedDeliveryWindow $estimated_delivery_window
 *      Only applies to tracking api responses.
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

    public function estimatedDeliveryWindow(): string
    {
        return EstimatedDeliveryWindow::class;
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

    public function getActivitiesAttribute($activities): Collection
    {
        return $activities ?? collect();
    }

    public function setActivityAttribute($activity): void
    {
        if ($activity instanceof Activity || $this->isAssociativeArray($activity)) {
            $activity = [$activity];
        }

        $this->attributes['activities'] = collect($activity);
    }

    /*
     * Indicates if the package has been delivered.
     * This method is only applicable when using the tracking api.
     */
    public function isDelivered(): bool
    {
        if ($this->activities->count() === 0) {
            return false;
        }

        return $this->activities
            ->filter(fn (Activity $a) => $a->isDelivered())
            ->count() > 0;
    }

    /*
     * Indicates if the package has been picked up.
     * Only applicable when using the tracking api.
     */
    public function isPickedUp(): bool
    {
        if ($this->activities->count() === 0) {
            return false;
        }

        return $this->activities
            ->filter(fn (Activity $a) => $a->isPickup())
            ->count() > 0;
    }

    /*
     * Returns the name of the person who signed for the package if
     * it has been delivered when using the tracking api.
     */
    public function signedForByName(): null|string
    {
        if (! $this->isDelivered()) {
            return null;
        }

        /** @var \Rawilk\Ups\Entity\Activity\Activity $activity */
        $activity = $this->activities
            ->filter(fn (Activity $a) => $a->isDelivered())
            ->first();

        return $activity->signed_for_by_name;
    }
}
