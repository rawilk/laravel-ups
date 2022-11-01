<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\PackageServiceOptions;

use Rawilk\Ups\Entity\Shipment\PackageServiceOptions\HazMatPackageInformation;
use Rawilk\Ups\Tests\TestCase;

class HazMatPackageInformationTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <HazMatPackageInformation>
            <AllPackedInOneIndicator />
            <OverPackedIndicator />
            <QValue>3</QValue>
            <OuterPackagingType>foo</OuterPackagingType>
        </HazMatPackageInformation>
        XML;

        $entity = new HazMatPackageInformation([
            'all_packed_in_one' => true,
            'over_packed' => true,
            'q_value' => '3',
            'outer_packaging_type' => 'foo',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
