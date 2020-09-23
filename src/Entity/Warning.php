<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity;

/**
 * @property string $code
 * @property null|string $description
 */
class Warning extends Entity
{
    protected array $attributeKeyMap = [
        'error_code' => 'code',
        'error_description' => 'description',
    ];

    protected function filled(): void
    {
        unset($this->error_severity);
    }
}
