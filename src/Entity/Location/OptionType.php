<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 * @property string $description
 */
class OptionType extends Entity
{
    /** @var string */
    public const LOCATION = '01';

    /** @var string */
    public const RETAIL_LOCATION = '02';

    /** @var string */
    public const ADDITIONAL_SERVICES = '03';

    /** @var string */
    public const PROGRAM_TYPE = '04';
}
