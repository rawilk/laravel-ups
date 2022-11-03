<?php

declare(strict_types=1);

use Rawilk\Ups\Concerns\HasFixedListSize;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Exceptions\InvalidMaxListSize;

it('sets a default list size automatically', function () {
    $class = new class extends Entity
    {
        use HasFixedListSize;
    };

    $entity = new $class;

    expect($entity->maximum_list_size)->toBe(10);
});

it('throws an exception for invalid list sizes', function (int $size) {
    $class = new class extends Entity
    {
        use HasFixedListSize;
    };

    $entity = new $class;
    $entity->maximum_list_size = $size;
})->with('invalidMaxListSizes')->expectException(InvalidMaxListSize::class);

dataset('invalidMaxListSizes', [
    -1,
    51,
]);
