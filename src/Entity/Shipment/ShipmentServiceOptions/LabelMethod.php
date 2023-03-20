<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions;

use Rawilk\Ups\Entity\Entity;

/**
 * @proeprty string $code
 *
 * @property null|string $description
 */
class LabelMethod extends Entity
{
    /** @var int */
    public const MAX_DESCRIPTION_LENGTH = 35;

    // Valid codes:
    public const PRINT_AND_MAIL = '01';

    public const ONE_ATTEMPT = '02';

    public const THREE_ATTEMPTS = '03';

    public const ELECTRONIC_LABEL = '04';

    public const PRINT_LABEL = '05';

    public function setDescriptionAttribute($description): void
    {
        if (strlen($description) > self::MAX_DESCRIPTION_LENGTH) {
            $description = substr($description, 0, self::MAX_DESCRIPTION_LENGTH);
        }

        $this->attributes['description'] = $description;
    }
}
