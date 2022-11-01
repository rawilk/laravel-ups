<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Shipment\SoldTo;
use Rawilk\Ups\Tests\TestCase;

class SoldToTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <SoldTo>
            <CompanyName>foo</CompanyName>
            <Address>
                <City>foo</City>
            </Address>
        </SoldTo>
        XML;

        $soldTo = new SoldTo([
            'company_name' => 'foo',
            'address' => new Address([
                'city' => 'foo',
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $soldTo->toSimpleXml(null, false)->asXML()
        );
    }
}
