<?php

declare(strict_types=1);

namespace Rawilk\Ups\Responses\Shipping;

use Rawilk\Ups\Concerns\HandlesApiFailures;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\PackageLevelResult;
use Rawilk\Ups\Entity\Shipment\VoidStatus;

/**
 * @property null|\Rawilk\Ups\Entity\Shipment\VoidStatus $status
 * @property null|\Illuminate\Support\Collection|\Rawilk\Ups\Entity\Shipment\PackageLevelResult[] $package_level_results
 */
class VoidResponse extends Entity
{
    use HandlesApiFailures;

    public function setPackageLevelResultsAttribute(array $packageLevelResults): void
    {
        // A single result was given back to us if this key is in the root array level.
        if (array_key_exists('tracking_number', $packageLevelResults)) {
            $packageLevelResults = [$packageLevelResults];
        }

        $this->attributes['package_level_results'] = collect($packageLevelResults)
            ->map(fn (array $data) => new PackageLevelResult($data));
    }

    public function status(): string
    {
        return VoidStatus::class;
    }

    public function packageLevelResult(): string
    {
        return PackageLevelResult::class;
    }

    /**
     * Callback for HandlesApiFailures::failed()
     */
    public function onFailed(): bool
    {
        return $this->status->failed();
    }
}
