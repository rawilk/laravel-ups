<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\PackageLevelResult;

it('creates from xml', function () {
    $xml = <<<'XML'
    <Element>
        <TrackingNumber>1Z...</TrackingNumber>
        <StatusCode>1</StatusCode>
        <Description>Voided</Description>
    </Element>
    XML;

    $entity = PackageLevelResult::fromXml(new SimpleXMLElement($xml));

    expect($entity->tracking_number)->toBe('1Z...')
        ->and($entity->status_code)->toBe('1')
        ->and($entity->description)->toBe('Voided')
        ->and($entity->voided())->toBeTrue()
        ->and($entity->notVoided())->toBeFalse();
});

it('can handle complex status codes', function () {
    $xml = <<<'XML'
    <Element>
        <TrackingNumber>1Z...</TrackingNumber>
        <StatusCode>
            <Code>0</Code>
        </StatusCode>
    </Element>
    XML;

    $entity = PackageLevelResult::fromXml(new SimpleXMLElement($xml));

    expect($entity->notVoided())->toBeTrue()
        ->and($entity->voided())->toBeFalse()
        ->and($entity->getStatusCode())->toBe('0');
});
