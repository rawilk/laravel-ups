<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\CreditCard;

it('converts to xml', function () {
    $expected = <<<'XML'
    <BillShipper>
        <AccountNumber>123</AccountNumber>
    </BillShipper>
    XML;

    $entity = new BillShipper([
        'account_number' => '123',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('can use a credit card element', function () {
    $expected = <<<'XML'
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('omits credit card element if account number is present', function () {
    $expected = <<<'XML'
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});
