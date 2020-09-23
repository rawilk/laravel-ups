<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Entity;

use Rawilk\Ups\Entity\Entity;

class WithRelationship extends Entity
{
    public function relatedEntity(): string
    {
        return RelatedEntity::class;
    }
}
