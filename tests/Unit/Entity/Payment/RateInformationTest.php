<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Payment\RateInformation;

it('converts to xml', function () {
    $expected = <<<'XML'
    <RateInformation>
        <NegotiatedRatesIndicator />
        <RateChartIndicator />
        <UserLevelDiscountIndicator />
    </RateInformation>
    XML;

    $rateInformation = new RateInformation([
        'negotiated_rates' => true,
        'rate_chart' => true,
        'user_level_discount' => true,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $rateInformation->toSimpleXml(null, false)->asXML(),
    );
});
