<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Payment;

use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\CreditCard;
use Rawilk\Ups\Tests\TestCase;

class BillShipperTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <BillShipper>
            <AccountNumber>123</AccountNumber>
        </BillShipper>
        XML;

        $entity = new BillShipper([
            'account_number' => '123',
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function can_use_credit_card(): void
    {
        $expected = <<<XML
        <BillShipper>
            <CreditCard>
                <Number>4111</Number>
            </CreditCard>
        </BillShipper>
        XML;

        $entity = new BillShipper([
            'credit_card' => new CreditCard([
                'number' => '4111',
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function omits_credit_card_if_account_number_present(): void
    {
        $expected = <<<XML
        <BillShipper>
            <AccountNumber>123</AccountNumber>
        </BillShipper>
        XML;

        $entity = new BillShipper([
            'account_number' => '123',
            'credit_card' => new CreditCard([
                'number' => '4111',
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
