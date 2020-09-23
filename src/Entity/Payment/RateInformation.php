<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Payment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property bool $negotiated_rates
 *      If true and the shipper is authorized, then Negotiated Rates should be returned in the response.
 * @property bool $rate_chart
 *      If true, the response will contain a RateChart Element.
 * @property bool $user_level_discount
 *      If true, user level discount will be applied to rates if applicable.
 */
class RateInformation extends Entity
{
    protected $casts = [
        'negotiated_rates' => 'boolean',
        'rate_chart' => 'boolean',
        'user_level_discount' => 'boolean',
    ];

    public function getNegotiatedRatesXmlTag(): string
    {
        return 'NegotiatedRatesIndicator';
    }

    public function getRateChartXmlTag(): string
    {
        return 'RateChartIndicator';
    }

    public function getUserLevelDiscountXmlTag(): string
    {
        return 'UserLevelDiscountIndicator';
    }
}
