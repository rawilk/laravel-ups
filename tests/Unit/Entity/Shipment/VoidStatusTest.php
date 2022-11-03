<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\VoidStatus;

it('can be partially voided', function () {
    $xml = <<<'XML'
    <VoidStatus>
        <StatusCode>
            <Code>2</Code>
        </StatusCode>
    </VoidStatus>
    XML;

    $voidStatus = VoidStatus::fromXml(new SimpleXMLElement($xml));

    expect($voidStatus->partiallyVoided())->toBeTrue()
        ->and($voidStatus->failed())->toBeFalse()
        // A partial void should also show as "successful".
        ->and($voidStatus->successful())->toBeTrue();
});

it('can be successful', function () {
    $xml = <<<'XML'
    <VoidStatus>
        <StatusCode>
            <Code>1</Code>
        </StatusCode>
    </VoidStatus>
    XML;

    $voidStatus = VoidStatus::fromXml(new SimpleXMLElement($xml));

    expect($voidStatus->successful())->toBeTrue()
        ->and($voidStatus->failed())->toBeFalse()
        ->and($voidStatus->partiallyVoided())->toBeFalse();
});

it('can fail', function () {
    $xml = <<<'XML'
    <VoidStatus>
        <StatusCode>
            <Code>0</Code>
        </StatusCode>
    </VoidStatus>
    XML;

    $voidStatus = VoidStatus::fromXml(new SimpleXMLElement($xml));

    expect($voidStatus->successful())->toBeFalse()
        ->and($voidStatus->failed())->toBeTrue()
        ->and($voidStatus->partiallyVoided())->toBeFalse();
});
