<?php

namespace Rawilk\Ups\Concerns;

use Illuminate\Support\Str;

trait HasAddressMapping
{
    public function setAddressLineAttribute($line): void
    {
        if (is_array($line)) {
            foreach ($line as $index => $addressLine) {
                $lineNumber = (int) $index + 1;

                $this->attributes["address_line{$lineNumber}"] = $addressLine;
            }

            return;
        }

        if (Str::contains($line, "\n")) {
            $this->setAddressLineAttribute(explode("\n", $line));

            return;
        }

        $this->attributes['address_line1'] = $line;
    }

    protected function mapPostalCode(array $attributes): void
    {
        if ($this->shouldAppendExtendedPostalCode($attributes)) {
            $this->attributes['postal_code'] .= "-{$attributes['postcode_extended_low']}";

            unset($this->postcode_extended_low);
        }
    }

    protected function shouldAppendExtendedPostalCode(array $attributes): bool
    {
        return array_key_exists('postcode_extended_low', $attributes)
            && $this->offsetExists('postal_code')
            && ! empty($attributes['postcode_extended_low']);
    }
}
