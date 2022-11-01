<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Payment;

use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\Prepaid;
use Rawilk\Ups\Tests\TestCase;

class PrepaidTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <Prepaid>
            <BillShipper>
                <AccountNumber>123</AccountNumber>
            </BillShipper>
        </Prepaid>
        XML;

        $prepaid = new Prepaid([
            'bill_shipper' => new BillShipper([
                'account_number' => '123',
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $prepaid->toSimpleXml(null, false)->asXML()
        );
    }
}
