<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\COD;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\CODAmount;

it('converts to xml', function () {
    $expected = <<<'XML'
    <COD>
        <CODCode>3</CODCode>
        <CODFundsCode>RU</CODFundsCode>
        <CODAmount>
            <MonetaryValue>10</MonetaryValue>
            <CurrencyCode>USD</CurrencyCode>
        </CODAmount>
    </COD>
    XML;

    $cod = new COD([
        'cod_funds_code' => 'RU',
        'cod_amount' => new CODAmount([
            'monetary_value' => '10',
            'currency_code' => 'USD',
        ]),
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $cod->toSimpleXml(null, false)->asXML(),
    );
});
