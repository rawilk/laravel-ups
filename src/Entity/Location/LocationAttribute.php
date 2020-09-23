<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;

/**
 * @property \Rawilk\Ups\Entity\Location\OptionType $option_type
 * @property \Rawilk\Ups\Entity\Location\OptionCode|\Rawilk\Ups\Entity\Location\OptionCode[] $option_code
 */
class LocationAttribute extends Entity
{
    public function optionCode(): string
    {
        return OptionCode::class;
    }

    public function optionType(): string
    {
        return OptionType::class;
    }
}
