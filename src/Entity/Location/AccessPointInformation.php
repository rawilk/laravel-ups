<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Illuminate\Support\Collection;
use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $public_access_point_id
 *      The public access point id associated with the UPS access point
 * @property null|string $image_url
 *      Image URL associated with UPS access point
 * @property null|\Rawilk\Ups\Entity\Location\AccessPointStatus $access_point_status
 *      Container for UPS AccessPointStatus
 * @property \Illuminate\Support\Collection $business_classifications
 */
class AccessPointInformation extends Entity
{
    protected array $attributeKeyMap = [
        'business_classification_list' => 'business_classifications',
    ];

    public function accessPointStatus(): string
    {
        return AccessPointStatus::class;
    }

    public function getBusinessClassificationsAttribute($value): Collection
    {
        return is_null($value)
            ? collect()
            : $value;
    }

    public function setBusinessClassificationsAttribute($value): void
    {
        $classifications = $value['business_classification'] ?? [];

        if (empty($classifications)) {
            $this->attributes['business_classifications'] = collect();

            return;
        }

        if (array_key_exists('code', $classifications)) {
            // There is only one single classification present, let's wrap it in an array.
            $classifications = [$classifications];
        }

        $this->attributes['business_classifications'] = collect($classifications)
            ->map(fn (array $data) => new BusinessClassification($data));
    }
}
