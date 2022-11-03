<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\PackageServiceOptions\HazMat;
use Rawilk\Ups\Exceptions\InvalidAttribute;

it('converts to xml', function () {
    $expected = <<<'XML'
    <HazMat>
        <aDRItemNumber>1</aDRItemNumber>
        <aDRPackagingGroupLetter>a</aDRPackagingGroupLetter>
        <IDNumber>foo</IDNumber>
        <PackagingTypeQuantity>10</PackagingTypeQuantity>
        <TechnicalName>foo</TechnicalName>
    </HazMat>
    XML;

    $entity = new HazMat([
        'adr_item_number' => '1',
        'adr_packaging_group_letter' => 'a',
        'id_number' => 'foo',
        'packaging_type_quantity' => 10,
        'technical_name' => 'foo',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('throws an exception for invalid packaging type quantity', function (int $quantity) {
    new HazMat([
        'packaging_type_quantity' => $quantity,
    ]);
})->with('invalidPackagingTypeQuantities')->expectException(InvalidAttribute::class);

dataset('invalidPackagingTypeQuantities', [
    HazMat::MIN_PACKAGING_TYPE_QUANTITY - 1,
    HazMat::MAX_PACKAGING_TYPE_QUANTITY + 1,
]);
