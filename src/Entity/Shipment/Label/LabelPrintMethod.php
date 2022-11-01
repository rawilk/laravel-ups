<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\Label;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 * @property null|string $description
 */
class LabelPrintMethod extends Entity
{
    // Valid codes:
    public const EPL = 'EPL';

    public const SPL = 'SPL';

    public const ZPL = 'ZPL';

    public const STAR = 'STAR';

    public const STARPL = 'STARPL';

    public const IMAGE = 'GIF';

    public function needsLabelStockSize(): bool
    {
        $needs = [
            self::EPL,
            self::ZPL,
            self::STARPL,
            self::SPL,
        ];

        return in_array($this->code, $needs, true);
    }
}
