<?php

declare(strict_types=1);

namespace Rawilk\Ups\Responses\AddressValidation;

use Illuminate\Support\Collection;
use Rawilk\Ups\Apis\AddressValidation\AddressValidationOption;
use Rawilk\Ups\Entity\AddressValidation\AddressClassification;
use Rawilk\Ups\Entity\AddressValidation\AddressValidationAddress;
use Rawilk\Ups\Entity\Entity;

/**
 * @property bool $ambiguous
 * @property bool $no_candidates
 * @property bool $valid
 * @property \Illuminate\Support\Collection|\Rawilk\Ups\Entity\AddressValidation\AddressValidationAddress[] $candidates
 * @property null|\Rawilk\Ups\Entity\AddressValidation\AddressClassification $address_classification
 */
class AddressValidationResponse extends Entity
{
    protected array $attributeKeyMap = [
        'ambiguous_address_indicator' => 'ambiguous',
        'no_candidates_indicator' => 'no_candidates',
        'valid_address_indicator' => 'valid',
        'address_key_format' => 'candidates',
    ];

    protected $casts = [
        'ambiguous' => 'boolean',
        'no_candidates' => 'boolean',
        'valid' => 'boolean',
    ];

    protected int $requestOption;

    public function addressClassification(): string
    {
        return AddressClassification::class;
    }

    public function usingRequestOption(int $requestOption): self
    {
        $this->requestOption = $requestOption;

        return $this;
    }

    public function getCandidatesAttribute($value): Collection
    {
        $addresses = $value ?? [];

        if (empty($addresses)) {
            return collect();
        }

        // If a single suggestion is returned from UPS, sometimes the array will be structured differently
        // than if there are multiple results, so we'll check for that now and wrap it in an array if needed.
        if (array_key_exists('country_code', $addresses)) {
            $addresses = [$addresses];
        }

        return collect($addresses)
            ->map(fn (array $data) => new AddressValidationAddress($data));
    }

    public function getValidAttribute($value): bool
    {
        if ($this->isAddressClassificationOnly()) {
            return $this->address_classification->code > AddressClassification::UNKNOWN;
        }

        return (bool) $value;
    }

    protected function isAddressClassificationOnly(): bool
    {
        return $this->requestOption === AddressValidationOption::ADDRESS_CLASSIFICATION;
    }
}
