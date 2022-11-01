<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity;

/**
 * @property string $code
 */
class CustomerClassification extends Entity
{
    // Valid codes:
    public const SHIPPER = '00';

    public const DAILY = '01';

    public const RETAIL = '04';

    public const REGIONAL = '05';

    public const GENLIST = '06';

    public const STDLIST = '53';
}
