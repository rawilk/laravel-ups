<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Concerns;

use Rawilk\Ups\Concerns\HasMonetaryValue;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Exceptions\InvalidMonetaryValue;
use Rawilk\Ups\Tests\TestCase;

class HasMonetaryValueTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider invalidValues
     *
     * @param  int|float  $value
     */
    public function throws_exception_for_invalid_monetary_values($value): void
    {
        $class = new class extends Entity
        {
            use HasMonetaryValue;
        };

        $this->expectException(InvalidMonetaryValue::class);

        new $class([
            'monetary_value' => $value,
        ]);
    }

    public function invalidValues(): array
    {
        return [
            [0],
            [999_999_999],
            [0.99],
        ];
    }
}
