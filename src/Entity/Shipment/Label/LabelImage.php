<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment\Label;

use Rawilk\Ups\Entity\Entity;

/**
 * @property \Rawilk\Ups\Entity\Shipment\Label\LabelImageFormat $label_image_format
 * @property string $graphic_image Base 64 encoded graphic image
 * @property string $html_image
 *      Base 64 encoded html browser image rendering software. This is only returned for GIF image formats.
 * @property string $url
 *      This is only returned if the label link is requested to be returned and only at the first package
 *      result.
 */
class LabelImage extends Entity
{
    public function labelImageFormat(): string
    {
        return LabelImageFormat::class;
    }
}
