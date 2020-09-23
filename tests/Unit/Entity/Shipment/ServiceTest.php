<?php

declare(strict_types=1);

namespace Rawilk\Ups\Tests\Unit\Entity\Shipment;

use Rawilk\Ups\Entity\Shipment\Service;
use Rawilk\Ups\Tests\TestCase;

class ServiceTest extends TestCase
{
    /** @test */
    public function sets_a_default_code(): void
    {
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

        self::assertXmlStringEqualsXmlString(
            $expected,
            $service->toSimpleXml(null, false)->asXML()
        );
    }

    /** @test */
    public function can_override_default_code(): void
    {
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

        self::assertXmlStringEqualsXmlString(
            $expected,
            $service->toSimpleXml(null, false)->asXML()
        );
    }
}
