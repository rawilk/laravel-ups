<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\UnitOfMeasurement;

it('defaults code to lbs', function () {
    expect((new UnitOfMeasurement)->code)->toBe(UnitOfMeasurement::LBS);
});

test('code can be set in the constructor', function () {
    $uom = new UnitOfMeasurement([
        'code' => UnitOfMeasurement::IN,
    ]);

    expect($uom->code)->not()->toBe(UnitOfMeasurement::LBS)
        ->and($uom->code)->toBe(UnitOfMeasurement::IN);
});

it('converts to xml', function () {
    $expectedXml = <<<'XML'
    <UnitOfMeasurement>
        <Code>LBS</Code>
        <Description>Pounds</Description>
    </UnitOfMeasurement>
    XML;

    $uom = new UnitOfMeasurement([
        'description' => 'Pounds',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expectedXml,
        $uom->toSimpleXml()->asXML(),
    );
});
