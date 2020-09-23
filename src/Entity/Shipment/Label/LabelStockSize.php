<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\Label;

use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Exceptions\InvalidAttribute;

/**
 * @property string $height Only valid value is 4
 * @property string $width Only valid values are 6 and 8.
 */
class LabelStockSize extends Entity
{
    /** @var string */
    public const DEFAULT_HEIGHT = '4';

    /** @var string */
    public const DEFAULT_WIDTH = '6';

    protected function booted(): void
    {
        $this->setAttribute('height', self::DEFAULT_HEIGHT);
        $this->setAttribute('width', self::DEFAULT_WIDTH);
    }

    public function setHeightAttribute($height): void
    {
        if ((string) $height !== self::DEFAULT_HEIGHT) {
            throw InvalidAttribute::withMessage(
                sprintf(
                    'Invalid label stock size height: Valid values are: %s',
                    self::DEFAULT_HEIGHT
                )
            );
        }

        $this->attributes['height'] = $height;
    }

    public function setWidthAttribute($width): void
    {
        $valid = ['6', '8'];

        if (! in_array($width, $valid, false)) {
            throw InvalidAttribute::withMessage(
                sprintf(
                    'Invalid label stock size width. Valid values are: %s',
                    implode(', ', $valid)
                )
            );
        }

        $this->attributes['width'] = $width;
    }
}
