<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;

/**
 * Package Level Result from Void Request.
 *
 * @property string $tracking_number
 * @property string|array $status_code
 * @property string $description
 */
class PackageLevelResult extends Entity
{
    // Statuses:
    protected const VOIDED = '1';

    protected const NOT_VOIDED = '0';

    public function notVoided(): bool
    {
        return $this->getStatusCode() === self::NOT_VOIDED;
    }

    public function voided(): bool
    {
        return $this->getStatusCode() === self::VOIDED;
    }

    public function getStatusCode(): string
    {
        if (is_array($this->status_code)) {
            return $this->status_code['code'];
        }

        return $this->status_code;
    }
}
