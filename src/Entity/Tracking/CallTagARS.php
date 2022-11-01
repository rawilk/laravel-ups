<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Tracking;

use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $code
 * @property null|string $number
 */
class CallTagARS extends Entity
{
    public const NO_RETURN = '00';

    public const CALL_TAG_SERVICE = '01';

    public const PRINT_AND_MAIL = '02';

    public const PICKUP_ATTEMPT = '03';

    public const PRINT_RETURN_LABEL = '04';

    public const ONLINE_CALL_TAG = '05';

    public const ELECTRONIC_RETURN_LABEL = '06';

    public const RETURNS_ON_THE_WEB = '08';
}
