<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Tests\Concerns\UsesFilesystem;
use Rawilk\Ups\Tests\Entity\BasicEntity;
use Rawilk\Ups\Tests\Entity\RelatedEntity;
use Rawilk\Ups\Tests\Entity\WithRelationship;
use Rawilk\Ups\Tests\TestCase;
use ReflectionClass;
use SimpleXMLElement;

class EntityTest extends TestCase
{
    use UsesFilesystem;

    /** @test */
    public function can_be_created_with_attributes(): void
    {
        $attributes = [
            'foo' => 'bar',
            'hello' => 'world',
        ];

        $entity = new BasicEntity($attributes);

        $reflection = (new ReflectionClass($entity))->getProperty('attributes');
        $reflection->setAccessible(true);

        self::assertEquals($attributes, $reflection->getValue($entity));
    }

    /** @test */
    public function can_get_a_specific_attribute(): void
    {
        $entity = new BasicEntity(['foo' => 'bar']);

        self::assertEquals('bar', $entity->foo);
    }

    /** @test */
    public function returns_null_for_non_existing_attributes(): void
    {
        $entity = new BasicEntity;

        self::assertNull($entity->unknown);
    }

    /** @test */
    public function can_set_a_specific_attribute(): void
    {
        $entity = new BasicEntity;

        $entity->foo = 'bar';

        $reflection = (new ReflectionClass($entity))->getProperty('attributes');
        $reflection->setAccessible(true);

        self::assertEquals(['foo' => 'bar'], $reflection->getValue($entity));
    }

    /** @test */
    public function can_be_extended_with_an_accessor(): void
    {
        $child = new class extends Entity {
            public function getFooAttribute($original): string
            {
                return 'baz';
            }
        };

        $entity = new $child(['foo' => 'bar']);

        self::assertNotEquals('bar', $entity->foo);
        self::assertEquals('baz', $entity->foo);
    }

    /** @test */
    public function can_be_transformed_to_array_with_accessor(): void
    {
        $child = new class extends Entity {
            public function getFooAttribute($original): string
            {
                return 'baz';
            }
        };

        $entity = new $child([
            'foo' => 'bar',
            'lorem' => 'ipsum',
        ]);

        self::assertEquals([
            'foo' => 'baz',
            'lorem' => 'ipsum',
        ], $entity->toArray());
    }

    /** @test */
    public function it_implements_array_access(): void
    {
        $entity = new BasicEntity(['foo' => 'bar']);

        self::assertInstanceOf(ArrayAccess::class, $entity);
        self::assertEquals('bar', $entity['foo']);
        self::assertNull($entity['unknown']);

        unset($entity['foo']);
        self::assertNull($entity['foo']);

        $entity['foo'] = 'baz';
        self::assertEquals('baz', $entity['foo']);
    }

    /** @test */
    public function can_be_transformed_into_an_array(): void
    {
        $entity = new BasicEntity(['foo' => 'bar']);

        self::assertInstanceOf(Arrayable::class, $entity);
        self::assertEquals(['foo' => 'bar'], $entity->toArray());
    }

    /** @test */
    public function can_be_transformed_to_json(): void
    {
        $entity = new BasicEntity(['foo' => 'bar']);

        self::assertInstanceOf(Jsonable::class, $entity);
        self::assertEquals('{"foo":"bar"}', $entity->toJson());
    }

    /** @test */
    public function it_is_json_serializable(): void
    {
        $entity = new BasicEntity(['foo' => 'bar']);

        self::assertInstanceOf(JsonSerializable::class, $entity);
        self::assertEquals('{"foo":"bar"}', json_encode($entity));
    }

    /** @test */
    public function serializes_to_json_when_casted_to_a_string(): void
    {
        $entity = new BasicEntity(['foo' => 'bar']);

        self::assertInstanceOf(Jsonable::class, $entity);
        self::assertEquals('{"foo":"bar"}', (string) $entity);
    }

    /** @test */
    public function can_be_transformed_into_xml(): void
    {
        $expectedXml = $this->getXmlContent('basic-xml');

        $entity = new BasicEntity([
            'foo' => 'bar',
            'has_nested_value' => [
                'nested_value' => 'Hello world',
            ],
        ]);

        self::assertXmlStringEqualsXmlString(
            $expectedXml->asXML(),
            $entity->toSimpleXml(new SimpleXMLElement('<BasicXml />'), false)->asXML()
        );
    }

    /** @test */
    public function can_be_created_from_xml(): void
    {
        $xml = <<<XML
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

        self::assertEquals($expected, $entity->toArray());
    }

    /** @test */
    public function from_xml_can_handle_nested_data_sets(): void
    {
        $xml = <<<XML
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

        self::assertEquals($expected, $entity->toArray());
    }

    /** @test */
    public function from_xml_supports_boolean_indicators(): void
    {
        $xml = <<<XML
        <Address>
            <Foo>bar</Foo>
            <SomeIndicator />
            <AnotherIndicator />
        </Address>
        XML;

        $class = new class extends Entity {
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

        self::assertIsBool($entity->some_indicator);
        self::assertIsBool($entity->another);

        self::assertFalse($entity->should_be_empty);

        self::assertTrue($entity->some_indicator);
        self::assertTrue($entity->another);

        self::assertEquals($expected, $entity->toArray());
    }

    /** @test */
    public function can_have_relationships(): void
    {
        $xml = <<<XML
        <WithRelationship>
            <Foo>Bar</Foo>
            <RelatedEntity>
                <Bar>Foo</Bar>
            </RelatedEntity>
        </WithRelationship>
        XML;

        $entity = WithRelationship::fromXml(new SimpleXMLElement($xml));

        self::assertSame('Bar', $entity->foo);
        self::assertInstanceOf(RelatedEntity::class, $entity->related_entity);
        self::assertSame('Foo', $entity->related_entity->bar);
    }

    /** @test */
    public function can_have_a_has_many_relationship(): void
    {
        $xml = <<<XML
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

        self::assertIsArray($entity->related_entity);
        self::assertCount(2, $entity->related_entity);

        self::assertSame('Related 1', $entity->related_entity[0]->name);
        self::assertSame('Related 2', $entity->related_entity[1]->name);
        self::assertSame('Extra prop', $entity->related_entity[1]->extra_property);
    }
}
