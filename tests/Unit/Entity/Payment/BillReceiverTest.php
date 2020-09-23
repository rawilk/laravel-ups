<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Payment;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\BillReceiver;
use Rawilk\Ups\Tests\TestCase;

class BillReceiverTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <BillReceiver>
            <AccountNumber>123456</AccountNumber>
            <Address>
                <AddressLine1>123 Any street</AddressLine1>
                <City>Anytown</City>
            </Address>
        </BillReceiver>
        XML;

        $entity = new BillReceiver([
            'account_number' => '123456',
            'address' => new Address([
                'address_line1' => '123 Any street',
                'city' => 'Anytown',
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
