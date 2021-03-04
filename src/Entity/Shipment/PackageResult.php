<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Imagick;
use ImagickPixel;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Shipment\Label\LabelImage;

/**
 * PackageResult is an entity returned from a ShipAccept response.
 *
 * @property string $tracking_number
 * @property null|\Rawilk\Ups\Entity\Shipment\Label\LabelImage $label_image
 */
class PackageResult extends Entity
{
    public function labelImage(): string
    {
        return LabelImage::class;
    }

    public function getDecodedImageContent(): null|string
    {
        if (! $this->label_image->graphic_image) {
            return null;
        }

        return base64_decode($this->label_image->graphic_image);
    }

    public function storeLabel(): null|string
    {
        $disk = Config::get('ups.label_storage_disk', 'default');

        $fileName = "{$this->tracking_number}.png";

        Storage::disk($disk)->put($fileName, base64_decode($this->label_image->graphic_image));

        if (Config::get('ups.rotate_stored_labels', true)) {
            $this->rotateLabel(Storage::disk($disk)->path($fileName));
        }

        return $fileName;
    }

    private function rotateLabel(string $path): void
    {
        if (! class_exists(Imagick::class)) {
            return;
        }

        $imagick = new Imagick($path);
        $imagick->rotateImage(new ImagickPixel, 90);

        $imagick->writeImage();
    }
}
