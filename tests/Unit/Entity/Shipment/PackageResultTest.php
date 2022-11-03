<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\PackageResult;

it('creates from xml', function () {
    $xml = <<<'XML'
    <PackageResult>
        <TrackingNumber>1Z...</TrackingNumber>
    </PackageResult>
    XML;

    $entity = PackageResult::fromXml(new SimpleXMLElement($xml));

    expect($entity->tracking_number)->toBe('1Z...');
});
