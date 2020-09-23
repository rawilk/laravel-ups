<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\ShipmentServiceOptions;

use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\COD;
use Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\CODAmount;
use Rawilk\Ups\Tests\TestCase;

class CODTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
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

        self::assertXmlStringEqualsXmlString(
            $expected,
            $cod->toSimpleXml(null, false)->asXML()
        );
    }
}
