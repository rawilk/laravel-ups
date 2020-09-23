<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $hours_type
 * @property \Rawilk\Ups\Entity\Location\DayOfWeek[] $days
 */
class StandardHours extends Entity
{
    /** @var string */
    public const REGULAR = '10';

    /** @var string */
    public const WILL_CALL = '11';

    /** @var string */
    public const SAME_DAY_WILL_CALL = '12';

    /** @var string */
    public const CUSTOMER_PICK_UP = '14';

    /** @var string */
    public const DROP_OFF = '50';

    /** @var string */
    public const PREP = '51';

    public function getDaysAttribute($days): array
    {
        return is_null($days)
            ? []
            : $days;
    }

    public function setDayOfWeekAttribute($days): void
    {
        if (! is_array($days)) {
            $days = $days instanceof DayOfWeek ? [$days] : [];
        }

        $this->attributes['days'] = $days;
    }

    public function dayOfWeek(): string
    {
        return DayOfWeek::class;
    }
}
