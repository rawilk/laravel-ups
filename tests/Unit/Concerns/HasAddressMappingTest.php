<?php

declare(strict_types=1);

use Rawilk\Ups\Concerns\HasAddressMapping;
use Rawilk\Ups\Entity\Entity;

it('maps address lines correctly', function () {
    $class = new class extends Entity
    {
        use HasAddressMapping;
    };

    $entity = new $class([
        'address_line' => [
            'line 1',
            'line 2',
            'line 3',
        ],
    ]);

    expect($entity->address_line1)->toBe('line 1')
        ->and($entity->address_line2)->toBe('line 2')
        ->and($entity->address_line3)->toBe('line 3');
});

test('multiple address lines can be set from a string', function () {
    $class = new class extends Entity
    {
        use HasAddressMapping;
    };

    $entity = new $class([
        'address_line' => "line 1\nline 2",
    ]);

    expect($entity->address_line1)->toBe('line 1')
        ->and($entity->address_line2)->toBe('line 2');
});

test('a single address line can be set', function () {
    $class = new class extends Entity
    {
        use HasAddressMapping;
    };

    $entity = new $class([
        'address_line' => 'line 1',
    ]);

    expect($entity->address_line1)->toBe('line 1')
        ->and($entity->address_line2)->toBeNull();
});

it('maps postal code correctly', function () {
    $class = new class extends Entity
    {
        use HasAddressMapping;

        public function filled(array $attributes): void
        {
            $this->mapPostalCode($attributes);
        }
    };

    $entity = new $class([
        'postal_code' => '12345',
        'postcode_extended_low' => '6789',
    ]);

    expect($entity->postal_code)->toBe('12345-6789')
        ->and(isset($entity->postcode_extended_low))->toBeFalse();
});
