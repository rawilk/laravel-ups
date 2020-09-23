<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;

/**
 * @property array $status_type
 * @property array $status_code
 */
class VoidStatus extends Entity
{
    /** @var string */
    protected const FAILED_CODE = '0';

    /** @var string */
    protected const SUCCESS_CODE = '1';

    /** @var string */
    protected const PARTIALLY_VOIDED_CODE = '2';

    public function failed(): bool
    {
        return in_array(self::FAILED_CODE, [$this->getStatusCode(), $this->getStatusTypeCode()], true);
    }

    public function successful(): bool
    {
        $successfulCodes = [self::SUCCESS_CODE, self::PARTIALLY_VOIDED_CODE];

        return in_array($this->getStatusCode(), $successfulCodes, true);
    }

    public function partiallyVoided(): bool
    {
        return $this->getStatusCode() === self::PARTIALLY_VOIDED_CODE;
    }

    public function getStatusTypeCode(): ?string
    {
        return $this->status_type['code'] ?? null;
    }

    public function getStatusCode(): ?string
    {
        return $this->status_code['code'] ?? null;
    }
}
