<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;

/**
 * @property int $day
 * @property null|string $open_hours
 *      Open time for a location in military format (HHMM). Midnight will be "0".
 * @property null|string $close_hours
 *      Close time for a location in military format (HHMM). Midnight will be "0".
 * @property null|string $latest_drop_off_hours
 * @property null|string $prep_hours
 * @property bool $closed
 * @property bool $open24_hours
 */
class DayOfWeek extends Entity
{
    protected array $attributeKeyMap = [
        'closed_indicator' => 'closed',
        'open24_hours_indicator' => 'open24_hours',
    ];

    protected $casts = [
        'closed' => 'boolean',
        'open24_hours' => 'boolean',
        'day' => 'integer',
    ];
}
