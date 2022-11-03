<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Payment\BillShipper;
use Rawilk\Ups\Entity\Payment\Prepaid;

it('converts to xml', function () {
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

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $prepaid->toSimpleXml(null, false)->asXML(),
    );
});
