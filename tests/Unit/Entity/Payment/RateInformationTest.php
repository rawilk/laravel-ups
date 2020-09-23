<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Payment;

use Rawilk\Ups\Entity\Payment\RateInformation;
use Rawilk\Ups\Tests\TestCase;

class RateInformationTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
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

        self::assertXmlStringEqualsXmlString(
            $expected,
            $rateInformation->toSimpleXml(null, false)->asXML()
        );
    }
}
