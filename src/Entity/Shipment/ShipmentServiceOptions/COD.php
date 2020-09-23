<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions;

use Rawilk\Ups\Entity\Entity;

/**
 * Collect On Delivery.
 * Shipment COD is only available for EU origin countries or territories and for shipper's account type Daily Pickup
 * and Drop Shipping. Not available to shipment with return service.
 *
 * @property string $cod_code
 * @property string $cod_funds_code
 *      For valid values refer to: Rating and Shipping COD Supported Countries or Territories in the UPS developer docs Appendix.
 * @property \Rawilk\Ups\Entity\Shipment\ShipmentServiceOptions\CODAmount $cod_amount
 */
class COD extends Entity
{
    /**
     * Tagless COD - only valid value found in the docs.
     *
     * @var string
     */
    protected const DEFAULT_COD_CODE = '3';

    protected function booted(): void
    {
        $this->setAttribute('cod_code', self::DEFAULT_COD_CODE);
    }

    public function codAmount(): string
    {
        return CODAmount::class;
    }

    public function getCodCodeXmlTag(): string
    {
        return 'CODCode';
    }

    public function getCodFundsCodeXmlTag(): string
    {
        return 'CODFundsCode';
    }
}
