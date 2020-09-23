<?php

namespace Rawilk\Ups\Tests\Unit\Concerns;

use Rawilk\Ups\Concerns\HasAddressMapping;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Tests\TestCase;

class HasAddressMappingTest extends TestCase
{
    /** @test */
    public function maps_address_lines_correctly(): void
    {
        $class = new class extends Entity {
            use HasAddressMapping;
        };

        $entity = new $class([
            'address_line' => [
                'line 1',
                'line 2',
                'line 3',
            ],
        ]);

        self::assertEquals('line 1', $entity->address_line1);
        self::assertEquals('line 2', $entity->address_line2);
        self::assertEquals('line 3', $entity->address_line3);
    }

    /** @test */
    public function multiple_address_lines_can_be_set_from_a_string(): void
    {
        $class = new class extends Entity {
            use HasAddressMapping;
        };

        $entity = new $class([
            'address_line' => "line 1\nline 2",
        ]);

        self::assertEquals('line 1', $entity->address_line1);
        self::assertEquals('line 2', $entity->address_line2);
    }

    /** @test */
    public function a_single_address_line_can_be_set(): void
    {
        $class = new class extends Entity {
            use HasAddressMapping;
        };

        $entity = new $class([
            'address_line' => 'line 1',
        ]);

        self::assertEquals('line 1', $entity->address_line1);
        self::assertNull($entity->address_line2);
    }

    /** @test */
    public function maps_postal_code_correctly(): void
    {
        $class = new class extends Entity {
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

        self::assertEquals('12345-6789', $entity->postal_code);
        self::assertFalse(isset($entity->postcode_extended_low));
    }
}
