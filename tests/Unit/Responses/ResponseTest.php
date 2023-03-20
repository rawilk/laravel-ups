<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Responses;

use Rawilk\Ups\Responses\Response;
use Rawilk\Ups\Tests\TestCase;
use SimpleXMLElement;

class ResponseTest extends TestCase
{
    /** @test */
    public function accepts_a_simple_xml_element(): void
    {
        $xml = <<<'XML'
        <Foo>
            <Attr>Value</Attr>
        </Foo>
        XML;

        $response = Response::fromXml(new SimpleXMLElement($xml));

        self::assertInstanceOf(SimpleXMLElement::class, $response->response());
        self::assertXmlStringEqualsXmlString($xml, $response->response()->asXML());
    }

    /** @test */
    public function can_have_raw_text(): void
    {
        $xml = <<<'XML'
        <Foo>
            <Attr>Value</Attr>
        </Foo>
        XML;

        $response = Response::fromXml(new SimpleXMLElement($xml))
            ->withText('foo');

        self::assertSame('foo', $response->text());
    }
}
