<?php

namespace Rawilk\Ups\Concerns;

use Rawilk\Ups\Exceptions\InvalidMonetaryValue;

/**
 * @property null|string $currency_code
 * @property float $monetary_value
 *
 * @mixin \Illuminate\Database\Eloquent\Concerns\HasAttributes
 */
trait HasMonetaryValue
{
    public function setMonetaryValueAttribute(float $value): void
    {
        if (! $this->isMonetaryValueValid($value)) {
            throw InvalidMonetaryValue::invalid($this->minMonetaryValue(), $this->maxMonetaryValue());
        }

        $this->attributes['monetary_value'] = $value;
    }

    protected function isMonetaryValueValid(float $value): bool
    {
        return $value >= $this->minMonetaryValue() && $value <= $this->maxMonetaryValue();
    }

    protected function minMonetaryValue(): float
    {
        return 1;
    }

    protected function maxMonetaryValue(): float
    {
        return 99_999_999;
    }
}
