<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $category
 * @property string $code
 * @property null|string $description
 * @property null|string $name
 */
class OptionCode extends Entity
{
    /** @var string */
    public const CATEGORY_NON_TRANSPORTATION = '06';

    /** @var string */
    public const CATEGORY_TRANSPORTATION = '07';
}
