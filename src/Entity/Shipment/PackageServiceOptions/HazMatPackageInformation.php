<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\PackageServiceOptions;

use Rawilk\Ups\Entity\Entity;

/**
 * @property bool $all_packed_in_one
 * @property bool $over_packed
 * @property null|string $q_value
 * @property null|string $outer_packaging_type
 */
class HazMatPackageInformation extends Entity
{
    protected array $attributeKeyMap = [
        'all_packed_in_one_indicator' => 'all_packed_in_one',
        'over_packed_indicator' => 'over_packed',
    ];

    protected $casts = [
        'all_packed_in_one' => 'boolean',
        'over_packed' => 'boolean',
    ];

    public function getAllPackedInOneXmlTag(): string
    {
        return 'AllPackedInOneIndicator';
    }

    public function getOverPackedXmlTag(): string
    {
        return 'OverPackedIndicator';
    }
}
