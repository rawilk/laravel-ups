<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment\Receipt;

use Rawilk\Ups\Entity\Shipment\Receipt\ImageFormat;
use Rawilk\Ups\Entity\Shipment\Receipt\ReceiptSpecification;
use Rawilk\Ups\Tests\TestCase;

class ReceiptSpecificationTest extends TestCase
{
    /** @test */
    public function converts_to_xml(): void
    {
        $expected = <<<XML
        <ReceiptSpecification>
            <ImageFormat>
                <Code>HTML</Code>
            </ImageFormat>
        </ReceiptSpecification>
        XML;

        $entity = new ReceiptSpecification([
            'image_format' => new ImageFormat([
                'code' => ImageFormat::HTML,
            ]),
        ]);

        self::assertXmlStringEqualsXmlString(
            $expected,
            $entity->toSimpleXml(null, false)->asXML()
        );
    }
}
