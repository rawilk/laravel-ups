<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\Label;

use Rawilk\Ups\Entity\Shipment\Label\LabelImage;
use Rawilk\Ups\Entity\Shipment\Label\LabelImageFormat;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class LabelImageTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<'XML'
        <LabelImage>
            <LabelImageFormat>
                <Code>GIF</Code>
            </LabelImageFormat>
            <GraphicImage>foo</GraphicImage>
            <HTMLImage>bar</HTMLImage>
            <URL>http://example.com</URL>
        </LabelImage>
        XML;

        $entity = LabelImage::fromXml(new SimpleXMLElement($xml));

        self::assertInstanceOf(LabelImageFormat::class, $entity->label_image_format);
        self::assertEquals('GIF', $entity->label_image_format->code);
        self::assertEquals('foo', $entity->graphic_image);
        self::assertEquals('bar', $entity->html_image);
        self::assertEquals('http://example.com', $entity->url);
    }
}
