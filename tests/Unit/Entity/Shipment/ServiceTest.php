<?php

declare(strict_types=1);

use Rawilk\Ups\Entity\Shipment\Service;

it('sets a default code', function () {
    $code = Service::DEFAULT_SERVICE_CODE;

    $expected = <<<XML
    <Service>
        <Code>{$code}</Code>
        <Description>foo</Description>
    </Service>
    XML;

    $service = new Service([
        'description' => 'foo',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $service->toSimpleXml(null, false)->asXML(),
    );
});

it('can override the default code', function () {
    $code = 'foo';

    $expected = <<<XML
    <Service>
        <Code>{$code}</Code>
        <Description>foo</Description>
    </Service>
    XML;

    $service = new Service([
        'code' => $code,
        'description' => 'foo',
    ]);

    $this->assertXmlStringEqualsXmlString(
        $expected,
        $service->toSimpleXml(null, false)->asXML(),
    );
});
