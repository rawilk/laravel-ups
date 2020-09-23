<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\Package;
use Rawilk\Ups\Tests\TestCase;

class PackageTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <Package>
            <PackageWeight>
                <UnitOfMeasurement>
                    <Code>LBS</Code>
                </UnitOfMeasurement>
            </PackageWeight>
            <PackageServiceOptions />
            <LargePackageIndicator />
        </Package>
        XML;

        $package = new Package([
            'is_large_package' => true,
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $package->toSimpleXml(null, false)->asXML()
        );
    }
}
