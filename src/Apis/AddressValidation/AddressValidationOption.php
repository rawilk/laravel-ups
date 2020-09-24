<?php

declare(strict_types=1);

namespace Rawilk\Ups\Apis\AddressValidation;

class AddressValidationOption
{
    /** @var int */
    public const ADDRESS_VALIDATION = 1;

    /** @var int */
    public const ADDRESS_CLASSIFICATION = 2;

    /** @var int */
    public const ADDRESS_VALIDATION_AND_CLASSIFICATION = 3;
}
