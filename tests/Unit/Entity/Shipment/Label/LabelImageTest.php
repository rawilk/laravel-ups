<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\Label\LabelImage;
use Rawilk\Ups\Entity\Shipment\Label\LabelImageFormat;

it('creates from xml', function () {
    $xml = <<<'XML'
    <LabelImage>
        <LabelImageFormat>
            <Code>GIF</Code>
        </LabelImageFormat>
        <GraphicImage>foo</GraphicImage>
        <HTMLImage>bar</HTMLImage>
        <URL>https://example.com</URL>
    </LabelImage>
    XML;

    $entity = LabelImage::fromXml(new SimpleXMLElement($xml));

    expect($entity->label_image_format)->toBeInstanceOf(LabelImageFormat::class)
        ->and($entity->label_image_format->code)->toBe('GIF')
        ->and($entity->graphic_image)->toBe('foo')
        ->and($entity->html_image)->toBe('bar')
        ->and($entity->url)->toBe('https://example.com');
});
