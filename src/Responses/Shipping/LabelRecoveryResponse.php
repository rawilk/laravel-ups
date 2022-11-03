<?php

declare(strict_types=1);

namespace Rawilk\Ups\Responses\Shipping;

use Illuminate\Support\Collection;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\Label\LabelResult;

/**
 * @property array $response
 * @property string $shipment_identification_number
 *      Tracking number of the leading package in the shipment.
 * @property \Illuminate\Support\Collection|\Rawilk\Ups\Entity\Shipment\Label\LabelResult[] $labels
 */
class LabelRecoveryResponse extends Entity
{
    public function getLabelsAttribute($labels): Collection
    {
        return $labels ?? collect();
    }

    public function setLabelResultsAttribute($labelResults): void
    {
        if ($this->isAssociativeArray($labelResults)) {
            // We were returned a single label result from the api.
            $labelResults = [$labelResults];
        }

        $this->attributes['labels'] = collect($labelResults)
            ->map(function (array $data) {
                $instance = new LabelResult;

                return $instance->fill($instance->convertPropertyNamesToSnakeCase($data));
            });
    }
}
