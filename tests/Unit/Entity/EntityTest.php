<?php

declare(strict_types=1);

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Tests\Entity\BasicEntity;
use Rawilk\Ups\Tests\Entity\RelatedEntity;
use Rawilk\Ups\Tests\Entity\WithRelationship;

it('can be created with attributes', function () {
    $attributes = [
        'foo' => 'bar',
        'hello' => 'world',
    ];

    $entity = new BasicEntity($attributes);

    $reflection = (new ReflectionClass($entity))->getProperty('attributes');
    $reflection->setAccessible(true);

    expect($reflection->getValue($entity))->toEqual($attributes);
});

it('can get a specific attribute', function () {
    $entity = new BasicEntity(['foo' => 'bar']);

    expect($entity->foo)->toBe('bar');
});

it('returns null for non existing attributes', function () {
    $entity = new BasicEntity;

    expect($entity->unknown)->toBeNull();
});

it('can set a specific attribute', function () {
    $entity = new BasicEntity;

    $entity->foo = 'bar';

    $reflection = (new ReflectionClass($entity))->getProperty('attributes');
    $reflection->setAccessible(true);

    expect($reflection->getValue($entity))->toEqual(['foo' => 'bar']);
});

it('can be extended with an accessor', function () {
    $child = new class extends Entity
    {
        public function getFooAttribute($original): string
        {
            return 'baz';
        }
    };

    $entity = new $child(['foo' => 'bar']);

    expect($entity->foo)->not()->toBe('bar')
        ->and($entity->foo)->toBe('baz');
});

it('can be transformed to array with an accessor', function () {
    $child = new class extends Entity
    {
        public function getFooAttribute($original): string
        {
            return 'baz';
        }
    };

    $entity = new $child([
        'foo' => 'bar',
        'lorem' => 'ipsum',
    ]);

    expect($entity->toArray())->toBe([
        'foo' => 'baz',
        'lorem' => 'ipsum',
    ]);
});

it('implements array access', function () {
    $entity = new BasicEntity(['foo' => 'bar']);

    expect($entity)->toBeInstanceOf(ArrayAccess::class)
        ->and($entity['foo'])->toBe('bar')
        ->and($entity['unknown'])->toBeNull();

    unset($entity['foo']);
    expect($entity['foo'])->toBeNull();

    $entity['foo'] = 'baz';
    expect($entity['foo'])->toBe('baz');
});

it('can be transformed into an array', function () {
    $entity = new BasicEntity(['foo' => 'bar']);

    expect($entity)->toBeInstanceOf(Arrayable::class)
        ->and($entity->toArray())->toBe([
            'foo' => 'bar',
        ]);
});

it('can be transformed to json', function () {
    $entity = new BasicEntity(['foo' => 'bar']);

    expect($entity)->toBeInstanceOf(Jsonable::class)
        ->and($entity->toJson())->toBe('{"foo":"bar"}');
});

it('is json serializable', function () {
    $entity = new BasicEntity(['foo' => 'bar']);

    expect($entity)->toBeInstanceOf(JsonSerializable::class)
        ->and(json_encode($entity))->toBe('{"foo":"bar"}');
});

it('serializes to json when casted to a string', function () {
    $entity = new BasicEntity(['foo' => 'bar']);

    expect($entity)->toBeInstanceOf(Jsonable::class)
        ->and((string) $entity)->toBe('{"foo":"bar"}');
});

it('can be transformed into xml', function () {
    $expectedXml = getXmlContent('basic-xml');

    $entity = new BasicEntity([
        'foo' => 'bar',
        'has_nested_value' => [
            'nested_value' => 'Hello world',
        ],
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expectedXml->asXML(),
        $entity->toSimpleXml(new SimpleXMLElement('<BasicXml />'), false)->asXML()
    );
});

it('can be created from xml', function () {
    $xml = <<<'XML'
    <Address>
        <City>Foo city</City>
        <StateProvinceCode>Foo state</StateProvinceCode>
        <AddressLine>Line 1</AddressLine>
        <AddressLine>Line 2</AddressLine>
    </Address>
    XML;

    $entity = BasicEntity::fromXml(new SimpleXMLElement($xml));

    $expected = [
        'city' => 'Foo city',
        'state_province_code' => 'Foo state',
        'address_line' => [
            'Line 1',
            'Line 2',
        ],
    ];

    expect($entity->toArray())->toBe($expected);
});

test('from xml can handle nested data sets', function () {
    $xml = <<<'XML'
    <Address>
        <City>Foo city</City>
        <NestedDataset>
            <Item1>Item 1</Item1>
            <NestedItem>
                <NestedItem1>Nested Item 1</NestedItem1>
                <NestedItem1>Nested Item 1 - 2</NestedItem1>
            </NestedItem>
        </NestedDataset>
    </Address>
    XML;

    $entity = BasicEntity::fromXml(new SimpleXMLElement($xml));

    $expected = [
        'city' => 'Foo city',
        'nested_dataset' => [
            'item1' => 'Item 1',
            'nested_item' => [
                'nested_item1' => [
                    'Nested Item 1',
                    'Nested Item 1 - 2',
                ],
            ],
        ],
    ];

    expect($entity->toArray())->toBe($expected);
});

test('from xml supports boolean indicators', function () {
    $xml = <<<'XML'
    <Address>
        <Foo>bar</Foo>
        <SomeIndicator />
        <AnotherIndicator />
    </Address>
    XML;

    $class = new class extends Entity
    {
        protected $casts = [
            'some_indicator' => 'boolean',
            'another' => 'boolean',
            'should_be_empty' => 'boolean',
        ];

        protected array $attributeKeyMap = [
            'another_indicator' => 'another',
        ];
    };

    $entity = $class::fromXml(new SimpleXMLElement($xml));

    $expected = [
        'foo' => 'bar',
        'some_indicator' => true,
        'another' => true,
    ];

    expect($entity->some_indicator)->toBeBool()
        ->and($entity->another)->toBeBool()
        ->and($entity->should_be_empty)->toBeFalse()
        ->and($entity->some_indicator)->toBeTrue()
        ->and($entity->another)->toBeTrue()
        ->and($entity->toArray())->toBe($expected);
});

it('can have relationships', function () {
    $xml = <<<'XML'
    <WithRelationship>
        <Foo>Bar</Foo>
        <RelatedEntity>
            <Bar>Foo</Bar>
        </RelatedEntity>
    </WithRelationship>
    XML;

    $entity = WithRelationship::fromXml(new SimpleXMLElement($xml));

    expect($entity->foo)->toBe('Bar')
        ->and($entity->related_entity)->toBeInstanceOf(RelatedEntity::class)
        ->and($entity->related_entity->bar)->toBe('Foo');
});

it('can have a has many relationship', function () {
    $xml = <<<'XML'
    <WithRelationship>
        <RelatedEntity>
            <Name>Related 1</Name>
        </RelatedEntity>
        <RelatedEntity>
            <Name>Related 2</Name>
            <ExtraProperty>Extra prop</ExtraProperty>
        </RelatedEntity>
    </WithRelationship>
    XML;

    $entity = WithRelationship::fromXml(new SimpleXMLElement($xml));

    expect($entity->related_entity)->toBeArray()
        ->and($entity->related_entity)->toHaveCount(2)
        ->and($entity->related_entity[0]->name)->toBe('Related 1')
        ->and($entity->related_entity[1]->name)->toBe('Related 2')
        ->and($entity->related_entity[1]->extra_property)->toBe('Extra prop');
});
