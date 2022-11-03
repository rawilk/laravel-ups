<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\AddressValidation\AddressClassification;
use Rawilk\Ups\Entity\AddressValidation\AddressValidationAddress;

it('can be created from xml', function () {
    $entity = AddressValidationAddress::fromXml(getXmlContent('address-validation-address'));

    expect($entity->toArray())->toEqual([
        'address_line1' => '7510 AIRWAY RD',
        'address_line2' => 'STE 7',
        'city' => 'SAN DIEGO',
        'state' => 'CA',
        'postal_code' => '92154-8034',
        'country_code' => 'US',
        'region' => 'SAN DIEGO CA 92154-8034',
    ]);
});

it('can have address classification', function () {
    $xml = <<<'XML'
    <AddressKeyFormat>
        <AddressLine>123 Any street</AddressLine>
        <AddressClassification>
            <Code>1</Code>
            <Description>Commercial</Description>
        </AddressClassification>
    </AddressKeyFormat>
    XML;

    $entity = AddressValidationAddress::fromXml(new SimpleXMLElement($xml));

    expect($entity->address_classification)->toBeInstanceOf(AddressClassification::class)
        ->and($entity->address_classification->code)->toBe(1)
        ->and($entity->address_classification->description)->toBe('Commercial')
        ->and($entity->address_line1)->toBe('123 Any street');
});
