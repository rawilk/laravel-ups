<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;

/**
 * @property null|string $account_number
 *      The account number to use for the UPS access point search in the country or territory. Used to locate a private network
 *      for the account. If present, any address or geocode search is ignored. Cannot be combined with $public_access_point_id parameter.
 * @property null|string $access_point_status
 * @property null|string $public_access_point_id
 *      If this parameter is present, any address or geocode search is ignored. Cannot be combined with $account_number search parameter.
 */
class AccessPointSearch extends Entity
{
    // Valid access point status codes:
    public const STATUS_ACTIVE_AVAILABLE = '01';
    public const STATUS_ACTIVE_UNAVAILABLE = '07';

    public function getPublicAccessPointIdXmlTag(): string
    {
        return 'PublicAccessPointID';
    }
}
