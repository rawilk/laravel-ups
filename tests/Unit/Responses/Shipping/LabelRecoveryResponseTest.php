<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Rawilk\Ups\Entity\Shipment\Label\LabelImage;
use Rawilk\Ups\Entity\Shipment\Label\LabelResult;
use Rawilk\Ups\Entity\Shipment\Receipt\Receipt;
use Rawilk\Ups\Responses\Shipping\LabelRecoveryResponse;

it('creates from xml', function () {
    $xml = <<<'XML'
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

    expect($entity->response)->toBeArray()
        ->and($entity->shipment_identification_number)->toBe('1Z1107YY8567985294')
        ->and($entity->labels)->toBeInstanceOf(Collection::class)
        ->and($entity->labels)->toHaveCount(1)
        ->and($entity->labels->first()->tracking_number)->toBe('1Z1107YY8567985294')
        ->and($entity->labels->first()->label_image)->toBeInstanceOf(LabelImage::class)
        ->and($entity->labels->first()->receipt)->toBeInstanceOf(Receipt::class);

    $this->assertContainsOnlyInstancesOf(LabelResult::class, $entity->labels);
});
