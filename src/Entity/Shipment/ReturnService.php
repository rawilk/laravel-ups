<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Rawilk\Ups\Entity\Entity;

/** @property string $code Type of return service. */
class ReturnService extends Entity
{
    // Return service codes (types):
    public const PRINT_AND_MAIL = '2';

    public const RETURN_SERVICE_1_ATTEMPT = '3';

    public const RETURN_SERVICE_3_ATTEMPTS = '5';

    public const ELECTRONIC_RETURN_LABEL = '8';

    public const PRINT_RETURN_LABEL = '9';

    public const EXCHANGE_PRINT_RETURN_LABEL = '10';

    public const PACK_AND_COLLECT_SERVICE_1_ATTEMPT_BOX_1 = '11';

    public const PACK_AND_COLLECT_SERVICE_1_ATTEMPT_BOX_2 = '12';

    public const PACK_AND_COLLECT_SERVICE_1_ATTEMPT_BOX_3 = '13';

    public const PACK_AND_COLLECT_SERVICE_1_ATTEMPT_BOX_4 = '14';

    public const PACK_AND_COLLECT_SERVICE_1_ATTEMPT_BOX_5 = '15';

    public const PACK_AND_COLLECT_SERVICE_3_ATTEMPT_BOX_1 = '16';

    public const PACK_AND_COLLECT_SERVICE_3_ATTEMPT_BOX_2 = '17';

    public const PACK_AND_COLLECT_SERVICE_3_ATTEMPT_BOX_3 = '18';

    public const PACK_AND_COLLECT_SERVICE_3_ATTEMPT_BOX_4 = '19';

    public const PACK_AND_COLLECT_SERVICE_3_ATTEMPT_BOX_5 = '20';

    public const DEFAULT_SERVICE_CODE = self::PRINT_RETURN_LABEL;

    protected function booted(): void
    {
        $this->setAttribute('code', self::DEFAULT_SERVICE_CODE);
    }

    /**
     * Convenience method to get the return services offered by UPS.
     */
    public static function availableServices(): array
    {
        return [
            self::PRINT_AND_MAIL => 'UPS Print and Mail (PNM)',
            self::RETURN_SERVICE_1_ATTEMPT => 'UPS Return Service 1-Attempt (RS1)',
            self::RETURN_SERVICE_3_ATTEMPTS => 'UPS Return Service 3-Attempt (RS3)',
            self::ELECTRONIC_RETURN_LABEL => 'UPS Electronic Return Label (ERL)',
            self::PRINT_RETURN_LABEL => 'UPS Print Return Label (PRL)',
            self::EXCHANGE_PRINT_RETURN_LABEL => 'UPS Exchange Print Return Label',
            self::PACK_AND_COLLECT_SERVICE_1_ATTEMPT_BOX_1 => 'UPS Pack & Collect Service 1-Attempt Box 1',
            self::PACK_AND_COLLECT_SERVICE_1_ATTEMPT_BOX_2 => 'UPS Pack & Collect Service 1-Attempt Box 2',
            self::PACK_AND_COLLECT_SERVICE_1_ATTEMPT_BOX_3 => 'UPS Pack & Collect Service 1-Attempt Box 3',
            self::PACK_AND_COLLECT_SERVICE_1_ATTEMPT_BOX_4 => 'UPS Pack & Collect Service 1-Attempt Box 4',
            self::PACK_AND_COLLECT_SERVICE_1_ATTEMPT_BOX_5 => 'UPS Pack & Collect Service 1-Attempt Box 5',
            self::PACK_AND_COLLECT_SERVICE_3_ATTEMPT_BOX_1 => 'UPS Pack & Collect Service 3-Attempt Box 1',
            self::PACK_AND_COLLECT_SERVICE_3_ATTEMPT_BOX_2 => 'UPS Pack & Collect Service 3-Attempt Box 2',
            self::PACK_AND_COLLECT_SERVICE_3_ATTEMPT_BOX_3 => 'UPS Pack & Collect Service 3-Attempt Box 3',
            self::PACK_AND_COLLECT_SERVICE_3_ATTEMPT_BOX_4 => 'UPS Pack & Collect Service 3-Attempt Box 4',
            self::PACK_AND_COLLECT_SERVICE_3_ATTEMPT_BOX_5 => 'UPS Pack & Collect Service 3-Attempt Box 5',
        ];
    }
}
