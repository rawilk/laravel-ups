<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Payment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillReceiver;
use Rawilk\Ups\Entity\Payment\FreightCollect;
use Rawilk\Ups\Tests\TestCase;

class FreightCollectTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<'XML'
        <FreightCollect>
            <BillReceiver>
                <AccountNumber>123</AccountNumber>
                <Address>
                    <City>foo</City>
                </Address>
            </BillReceiver>
        </FreightCollect>
        XML;

        $entity = new FreightCollect([
            'bill_receiver' => new BillReceiver([
                'account_number' => '123',
                'address' => new Address([
                    'city' => 'foo',
                ]),
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
