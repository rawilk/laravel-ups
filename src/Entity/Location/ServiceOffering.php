<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;

/**
 * @property string $code
 * @property string $description
 */
class ServiceOffering extends Entity
{
    // Valid codes:
    public const DIRECT_TO_RETAIL = '001';
    public const NOT_IN_ONE_ADL = '002';
    public const CLICK_AND_COLLECT = '003';
    public const RETAIL_TO_RETAIL = '004';
    public const PICKUP = '005';
    public const DROP_OFF = '006';
    public const PUDO = '007';
    public const EARLY_PICKUP_DELIVERY_TIME = '008';
    public const ACCEPT_PREPAID_DROP_OFFS = '009';
    public const DCO_DCR_INTERCEPT_ACCEPTED = '010';
    public const ACCEPTS_PAYMENTS = '011';
    public const PAY_AT_STORE = '012';
    public const ACCEPTS_RESTRICTED_ARTICLES = '013';
}
