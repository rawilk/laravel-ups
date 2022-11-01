<?php

namespace Rawilk\Ups\Concerns;

use Rawilk\Ups\Exceptions\InvalidMaxListSize;

trait HasFixedListSize
{
    protected static int $minListSize = 1;

    protected static int $maxListSize = 50;

    protected static int $defaultListSize = 10;

    protected function bootHasFixedListSize(): void
    {
        $this->setAttribute('maximum_list_size', self::$defaultListSize);
    }

    public function setMaximumListSizeAttribute(int $size): void
    {
        if (! $this->isMaxListSizeValid($size)) {
            throw InvalidMaxListSize::invalid(self::$minListSize, self::$maxListSize, self::$defaultListSize);
        }

        $this->attributes['maximum_list_size'] = $size;
    }

    protected function isMaxListSizeValid(int $size): bool
    {
        return $size >= self::$minListSize && $size <= self::$maxListSize;
    }
}
