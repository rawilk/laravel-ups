<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $description
 * @property string $code
 */
class AccessPointStatus extends Entity
{
    /** @var string */
    public const ACTIVE_AVAILABLE = '01';

    /** @var string */
    public const SUSPENDED = '06';

    /** @var string */
    public const ACTIVE_UNAVAILABLE = '07';

    /** @var string */
    public const TERMINATED = '08';
}
