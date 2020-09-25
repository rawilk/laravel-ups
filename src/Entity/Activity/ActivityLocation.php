<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Activity;

use Rawilk\Ups\Entity\Address\Address;
use Rawilk\Ups\Entity\Entity;

/**
 * @property \Rawilk\Ups\Entity\Address\Address $address
 * @property null|\Rawilk\Ups\Entity\Activity\AddressArtifactFormat $address_artifact_format
 * @property string $code Activity Location code
 * @property string $description Activity location description
 * @property null|string $signed_for_by_name Name of the person who signed
 */
class ActivityLocation extends Entity
{
    public function address(): string
    {
        return Address::class;
    }

    public function addressArtifactFormat(): string
    {
        return AddressArtifactFormat::class;
    }

    public function setSignedForByNameAttribute($name): void
    {
        // If this attribute is present but empty in the api response, it will be represented
        // as an array when we receive it. In those cases, convert the array to a null value.
        if (is_array($name)) {
            $name = null;
        }

        $this->attributes['signed_for_by_name'] = $name;
    }
}
