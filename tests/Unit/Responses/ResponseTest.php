<?php

declare(strict_types=1);

use Rawilk\Ups\Responses\Response;

it('accepts a simple xml element', function () {
    $xml = <<<'XML'
    <Foo>
        <Attr>Value</Attr>
    </Foo>
    XML;

    $response = Response::fromXml(new SimpleXMLElement($xml));

    expect($response->response())->toBeInstanceOf(SimpleXMLElement::class);

    $this->assertXmlStringEqualsXmlString($xml, $response->response()->asXML());
});

it('can have raw text', function () {
    $xml = <<<'XML'
    <Foo>
        <Attr>Value</Attr>
    </Foo>
    XML;

    $response = Response::fromXml(new SimpleXMLElement($xml))
        ->withText('foo');

    expect($response->text())->toBe('foo');
});
