<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\AddressValidation\AddressClassification;

it('casts code as an integer', function () {
    $entity = new AddressClassification(['code' => '2']);

    expect($entity->code)->toBeInt()
        ->and($entity->code)->toBe(2);
});

it('converts to xml', function () {
    $expected = <<<'XML'
    <AddressClassification>
        <Code>1</Code>
        <Description>Commercial</Description>
    </AddressClassification>
    XML;

    $entity = new AddressClassification([
        'code' => AddressClassification::COMMERCIAL,
        'description' => 'Commercial',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('creates from xml', function () {
    $xml = <<<'XML'
    <AddressClassification>
        <Code>1</Code>
        <Description>Commercial</Description>
    </AddressClassification>
    XML;

    $entity = AddressClassification::fromXml(new SimpleXMLElement($xml));

    expect($entity->toArray())->toBe([
        'code' => 1,
        'description' => 'Commercial',
    ]);
});
