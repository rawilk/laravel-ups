<?php

declare(strict_types=1);

namespace Rawilk\Ups\Responses\Shipping;

use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\PackageLevelResult;
use Rawilk\Ups\Entity\Shipment\VoidStatus;

/**
 * @property array $response
 * @property null|\Rawilk\Ups\Entity\Shipment\VoidStatus $status
 * @property null|\Illuminate\Support\Collection|\Rawilk\Ups\Entity\Shipment\PackageLevelResult[] $package_level_results
 * @property null|string $error_description
 * @property null|string $error_code
 */
class VoidResponse extends Entity
{
    /** @var string */
    protected const FAILURE_CODE = '0';

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

    public function failed(): bool
    {
        if ($this->response['response_status_code'] === self::FAILURE_CODE) {
            return true;
        }

        if (isset($this->response['error']) && ! empty($this->response['error'])) {
            return true;
        }

        return $this->status->failed();
    }

    public function getErrorCodeAttribute(): ?string
    {
        if (! isset($this->response['error'])) {
            return null;
        }

        return $this->response['error']['error_code'] ?? '0';
    }

    public function getErrorDescriptionAttribute(): ?string
    {
        if (! isset($this->response['error'])) {
            return null;
        }

        return $this->response['error']['error_description'] ?? 'Unknown Error';
    }
}
