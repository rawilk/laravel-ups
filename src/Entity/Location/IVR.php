<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Location;

use Rawilk\Ups\Entity\Entity;

/**
 * Integrated Voice Response
 *
 * @property string $phrase_id
 * @property bool $text_to_speech
 *      If true, indicates to the response recipient that the information has changed, and a new audio file should be produced.
 */
class IVR extends Entity
{
    protected array $attributeKeyMap = [
        'text_to_speech_indicator' => 'text_to_speech',
    ];

    protected $casts = [
        'text_to_speech' => 'boolean',
    ];
}
