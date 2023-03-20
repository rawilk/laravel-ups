<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\Label;

use Rawilk\Ups\Entity\Shipment\Label\LabelImage;
use Rawilk\Ups\Entity\Shipment\Label\LabelImageFormat;
use Rawilk\Ups\Entity\Shipment\Label\LabelResult;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class LabelResultTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<'XML'
        <LabelResult>
            <TrackingNumber>1Z...</TrackingNumber>
            <LabelImage>
                <LabelImageFormat>
                    <Code>GIF</Code>
                </LabelImageFormat>
                <GraphicImage>foo</GraphicImage>
                <HTMLImage>bar</HTMLImage>
                <URL>http://example.com</URL>
            </LabelImage>
        </LabelResult>
        XML;

        $entity = LabelResult::fromXml(new SimpleXMLElement($xml));

        self::assertEquals('1Z...', $entity->tracking_number);
        self::assertInstanceOf(LabelImage::class, $entity->label_image);
        self::assertInstanceOf(LabelImageFormat::class, $entity->label_image->label_image_format);
    }
}
