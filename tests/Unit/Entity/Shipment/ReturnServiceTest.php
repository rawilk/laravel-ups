<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\ReturnService;

it('sets a default code', function () {
    $defaultCode = ReturnService::DEFAULT_SERVICE_CODE;

    $expected = <<<XML
    <ReturnService>
        <Code>{$defaultCode}</Code>
    </ReturnService>
    XML;

    $entity = new ReturnService;

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

test('default service code can be overridden', function () {
    $code = 'foo';

    $expected = <<<XML
    <ReturnService>
        <Code>{$code}</Code>
    </ReturnService>
    XML;

    $entity = new ReturnService([
        'code' => $code,
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $entity->toSimpleXml(null, false)->asXML(),
    );
});

it('can get a list of available services', function () {
    $services = ReturnService::availableServices();

    expect($services)->toBeArray()
        ->and($services)->not()->toBeEmpty();
});
