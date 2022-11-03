<?php

declare(strict_types=1);

use Rawilk\Ups\Support\Xml;

it('can convert simple xml element to array', function () {
    $xml = getXmlContent('basic-xml');

    expect(Xml::toArray($xml))->toBe([
        'Foo' => 'bar',
        'HasNestedValue' => [
            'NestedValue' => 'Hello world',
        ],
    ]);
});
