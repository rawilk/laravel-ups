<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Shipment;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
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

    public function storeLabel(): string
    {
        $disk = Config::get('ups.label_storage_disk', 'default');

        $fileName = "{$this->tracking_number}.gif";

        $content = Config::get('ups.rotate_stored_labels', true)
            ? $this->rotateLabel($this->label_image->graphic_image)
            : base64_decode($this->label_image->graphic_image);

        Storage::disk($disk)->put($fileName, $content);

        return $fileName;
    }

    private function rotateLabel(string $gif): string
    {
        // See: https://pjstrnad.com/rotation-image-ups-php/
        $image = imagecreatefromgif('data://text/plain;base64,' . $gif);
        $image = imagerotate($image, 270, 0);

        ob_start();

        imagegif($image);
        $imageBase64 = base64_encode(ob_get_contents());

        ob_end_clean();

        return base64_decode($imageBase64);
    }
}
