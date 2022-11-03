<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\Label\LabelStockSize;
use Rawilk\Ups\Exceptions\InvalidAttribute;

it('sets width and height automatically', function () {
    $expected = <<<'XML'
    <LabelStockSize>
        <Height>4</Height>
        <Width>6</Width>
    </LabelStockSize>
    XML;

    $this->assertXmlStringEqualsXmlString(
        $expected,
        (new LabelStockSize)->toSimpleXml(null, false)->asXML(),
    );
});

test('width can be customized', function () {
    $expected = <<<'XML'
    <LabelStockSize>
        <Height>4</Height>
        <Width>8</Width>
    </LabelStockSize>
    XML;

    $entity = new LabelStockSize([
        'width' => '8',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('throws an exception for invalid width', function () {
    new LabelStockSize([
        'width' => '4',
    ]);
})->expectException(InvalidAttribute::class);

it('throws an exception for invalid height', function () {
    new LabelStockSize([
        'height' => '6',
    ]);
})->expectException(InvalidAttribute::class);
