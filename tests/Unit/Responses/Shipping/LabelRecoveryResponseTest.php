<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Responses\Shipping;

use Illuminate\Support\Collection;
use Rawilk\Ups\Entity\Shipment\Label\LabelImage;
use Rawilk\Ups\Entity\Shipment\Label\LabelResult;
use Rawilk\Ups\Entity\Shipment\Receipt\Receipt;
use Rawilk\Ups\Responses\Shipping\LabelRecoveryResponse;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class LabelRecoveryResponseTest extends TestCase
{
    /** @test */
    public function creates_from_xml(): void
    {
        $xml = <<<XML
        <LabelRecoveryResponse>
            <Response>
                <ResponseStatusCode>1</ResponseStatusCode>
                <ResponseStatusDescription>Success</ResponseStatusDescription>
            </Response>
            <ShipmentIdentificationNumber>1Z1107YY8567985294</ShipmentIdentificationNumber>
            <LabelResults>
                <TrackingNumber>1Z1107YY8567985294</TrackingNumber>
                <LabelImage>
                    <LabelImageFormat>
                        <Code>GIF</Code>
                    </LabelImageFormat>
                    <GraphicImage>R0lGODdheAUgA+cAAAAAAAEBAQICAgMDAwQEBAUFBQYGBg(Truncated)</GraphicImage>
                    <HTMLImage>PCFET0NUWVBFIEhUTUwgUFVCTElDICItLy9JRVRGLy9EVEQgSF(Truncated)</HTMLImage>
                    <URL>https://www.ups.com/u.a/L.class?8RY86r2n6CmK%2B53TmeX42gtY6%2BsAMRcrqsP0M8</URL>
                </LabelImage>
                <Receipt>
                    <HTMLImage>PGh0bWw+PGhlYWQ+PHRpdGxlPlJlY2VpcHQ8L3RpdGxlPjwvaGVhZ(Truncated)</HTMLImage>
                    <URL>https://www.ups.com/u.a/L.class?8RY86r2n6CmK%2B53TmeX42gtY6%2BsAMRcrqsPBMi</URL>
                </Receipt>
            </LabelResults>
        </LabelRecoveryResponse>
        XML;

        $entity = LabelRecoveryResponse::fromXml(new SimpleXMLElement($xml));

        self::assertIsArray($entity->response);
        self::assertEquals('1Z1107YY8567985294', $entity->shipment_identification_number);
        self::assertInstanceOf(Collection::class, $entity->labels);
        self::assertContainsOnlyInstancesOf(LabelResult::class, $entity->labels);
        self::assertCount(1, $entity->labels);
        self::assertEquals('1Z1107YY8567985294', $entity->labels->first()->tracking_number);
        self::assertInstanceOf(LabelImage::class, $entity->labels->first()->label_image);
        self::assertInstanceOf(Receipt::class, $entity->labels->first()->receipt);
    }
}
