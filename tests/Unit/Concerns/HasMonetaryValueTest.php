<?php

declare(strict_types=1);

use Rawilk\Ups\Concerns\HasMonetaryValue;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Exceptions\InvalidMonetaryValue;

it('throws an exception for invalid monetary values', function (int|float $value) {
    $class = new class extends Entity
    {
        use HasMonetaryValue;
    };

    new $class([
        'monetary_value' => $value,
    ]);
})->with('invalidValues')->expectException(InvalidMonetaryValue::class);

dataset('invalidValues', [
    0,
    999_999_999,
    0.99,
]);
