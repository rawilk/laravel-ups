<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Concerns\HasFixedListSize;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Exceptions\InvalidSearchRadius;

/**
 * @property int $maximum_list_size
 * @property string $search_radius
 *      Valid values are between 5-100 for MI and 5-150 for KM. Default is 100 miles.
 * @property null|\Rawilk\Ups\Entity\Location\AccessPointSearch $access_point_search
 *      Applicable only for RequestOption "64"
 */
class LocationSearchCriteria extends Entity
{
    use HasFixedListSize;

    /** @var int */
    protected const MINIMUM_SEARCH_RADIUS = 5;

    /** @var int */
    protected const MAXIMUM_SEARCH_RADIUS = 150;

    /** @var int */
    protected const DEFAULT_SEARCH_RADIUS = 100;

    protected function booted(): void
    {
        $this->setAttribute('search_radius', self::DEFAULT_SEARCH_RADIUS);
    }

    public function accessPointSearch(): string
    {
        return AccessPointSearch::class;
    }

    public function setSearchRadiusAttribute($radius): void
    {
        if (! $this->isValidRadius((int) $radius)) {
            throw InvalidSearchRadius::invalid(self::MINIMUM_SEARCH_RADIUS, self::MAXIMUM_SEARCH_RADIUS);
        }

        $this->attributes['search_radius'] = (string) $radius;
    }

    protected function isValidRadius(int $radius): bool
    {
        return $radius >= self::MINIMUM_SEARCH_RADIUS && $radius <= self::MAXIMUM_SEARCH_RADIUS;
    }
}
