<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\PackageServiceOptions;

use Rawilk\Ups\Entity\Shipment\PackageServiceOptions\HazMat;
use Rawilk\Ups\Exceptions\InvalidAttribute;
use Rawilk\Ups\Tests\TestCase;

class HazMatTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
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

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /**
     * @test
     * @dataProvider invalidPackagingTypeQuantities
     * @param int $quantity
     */
    public function throws_exceptions_for_invalid_packaging_type_quantity(int $quantity): void
    {
        $this->expectException(InvalidAttribute::class);

        new HazMat([
            'packaging_type_quantity' => $quantity,
        ]);
    }

    public function invalidPackagingTypeQuantities(): array
    {
        return [
            [HazMat::MIN_PACKAGING_TYPE_QUANTITY - 1],
            [HazMat::MAX_PACKAGING_TYPE_QUANTITY + 1],
        ];
    }
}
