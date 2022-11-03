<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\Label\LabelImage;
use Rawilk\Ups\Entity\Shipment\Label\LabelImageFormat;
use Rawilk\Ups\Entity\Shipment\Label\LabelResult;

it('creates from xml', function () {
    $xml = <<<'XML'
    <LabelResult>
        <TrackingNumber>1Z...</TrackingNumber>
        <LabelImage>
            <LabelImageFormat>
                <Code>GIF</Code>
            </LabelImageFormat>
            <GraphicImage>foo</GraphicImage>
            <HTMLImage>bar</HTMLImage>
            <URL>https://example.com</URL>
        </LabelImage>
    </LabelResult>
    XML;

    $entity = LabelResult::fromXml(new SimpleXMLElement($xml));

    expect($entity->tracking_number)->toBe('1Z...')
        ->and($entity->label_image)->toBeInstanceOf(LabelImage::class)
        ->and($entity->label_image->label_image_format)->toBeInstanceOf(LabelImageFormat::class);
});
