<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Payment\CreditCard;

it('converts to xml', function () {
    $expected = <<<'XML'
    <CreditCard>
        <Type>visa</Type>
        <Number>4111</Number>
        <ExpirationDate>02/20</ExpirationDate>
        <SecurityCode>123</SecurityCode>
        <Address>
            <City>foo</City>
        </Address>
    </CreditCard>
    XML;

    $card = new CreditCard([
        'type' => 'visa',
        'number' => '4111',
        'expiration_date' => '02/20',
        'security_code' => '123',
        'address' => new Address([
            'city' => 'foo',
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $card->toSimpleXml(null, false)->asXML(),
    );
});
