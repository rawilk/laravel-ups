<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Activity;

use Rawilk\Ups\Entity\Entity;

/**
 * @property \Rawilk\Ups\Entity\Activity\AddressArtifactFormat $address_artifact_format
 */
class ActivityLocation extends Entity
{
    public function addressArtifactFormat(): string
    {
        return AddressArtifactFormat::class;
    }
}
