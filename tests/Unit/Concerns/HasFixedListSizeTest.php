<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Concerns;

use Rawilk\Ups\Concerns\HasFixedListSize;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Exceptions\InvalidMaxListSize;
use Rawilk\Ups\Tests\TestCase;

class HasFixedListSizeTest extends TestCase
{
    /** @test */
    public function sets_a_default_list_size_automatically(): void
    {
        $class = new class extends Entity
        {
            use HasFixedListSize;
        };

        $entity = new $class;

        self::assertEquals(10, $entity->maximum_list_size);
    }

    /**
     * @test
     *
     * @dataProvider invalidMaxListSizes
     */
    public function throws_an_exception_for_invalid_list_sizes(int $size): void
    {
        $this->expectException(InvalidMaxListSize::class);

        $class = new class extends Entity
        {
            use HasFixedListSize;
        };

        $entity = new $class;
        $entity->maximum_list_size = $size;
    }

    public function invalidMaxListSizes(): array
    {
        return  [
            [-1],
            [51],
        ];
    }
}
